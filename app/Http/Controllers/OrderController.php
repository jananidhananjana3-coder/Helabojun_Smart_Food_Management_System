<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use App\Models\Outlet;
use App\Models\OrderItem;
use App\Models\KitchenTicket;
use App\Models\QueueDisplay;
use App\Models\Counter;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display all orders.
     */
    public function index()
    {
        $orders = Order::with([
            'user',
            'outlet',
            'counter',
            'orderItems.food',
            'payment',
            'kitchenTicket',
        ])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }


    /**
     * Show order creation page.
     */
    public function create()
    {
        $outlets = Outlet::where('status', 'active')->get();

        $counters = Counter::where('status', 'active')->get();

        $foods = Food::with([
            'category',
            'counters',
        ])
            ->whereHas('counters', function ($query) {
                $query->where('food_counter.quantity', '>', 0);
            })
            ->get();

        return view(
            'orders.create',
            compact('foods', 'outlets', 'counters')
        );
    }


    /**
     * Normal order store.
     *
     * Supports:
     * - cashier cart
     * - single-food order
     */
    public function store(Request $request)
    {
        if (!$request->has('items')) {
            $request->merge([
                'counter_id' => $request->input('counter_id'),

                'items' => [
                    [
                        'food_id' => $request->input('food_id'),
                        'quantity' => (int) $request->input('quantity', 1),
                    ],
                ],

                'order_type' => $request->input(
                    'order_type',
                    'dine_in'
                ),

                'payment_method' => $request->input(
                    'payment_method',
                    'cash'
                ),

                'discount' => $request->input(
                    'discount',
                    0
                ),

                'cash_received' => $request->input(
                    'cash_received',
                    0
                ),
            ]);
        }

        return $this->cashierStore($request);
    }


    /**
     * Store cashier order.
     *
     * FINAL FLOW:
     *
     * Cashier
     *   ↓
     * Counter validation
     *   ↓
     * Food validation
     *   ↓
     * Counter stock lock
     *   ↓
     * Price calculation
     *   ↓
     * Order
     *   ↓
     * Order Items
     *   ↓
     * Reduce selected counter stock
     *   ↓
     * Payment
     *   ↓
     * Kitchen Ticket
     *   ↓
     * Queue Display
     */
    public function cashierStore(Request $request)
    {
        $data = $request->validate([
            'counter_id' => [
                'required',
                'integer',
                'exists:counters,id',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.food_id' => [
                'required',
                'integer',
                'exists:foods,id',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'order_type' => [
                'required',
                'in:dine_in,take_away',
            ],

            'payment_method' => [
                'required',
                'in:cash,card,qr',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'cash_received' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Validate counter
        |--------------------------------------------------------------------------
        */

        $counter = Counter::whereKey($data['counter_id'])
            ->where('status', 'active')
            ->first();

        if (
            !$counter ||
            (
                $user->outlet_id &&
                (int) $counter->outlet_id !==
                (int) $user->outlet_id
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid counter for this cashier outlet.',
            ], 422);
        }


        try {

            $result = DB::transaction(function () use (
                $data,
                $counter,
                $user
            ) {

                $subtotal = 0;

                $items = [];


                /*
                |--------------------------------------------------------------------------
                | Validate every item
                |--------------------------------------------------------------------------
                */

                foreach ($data['items'] as $row) {

                    $food = Food::with('category')
                        ->whereKey($row['food_id'])
                        ->where(
                            'outlet_id',
                            $counter->outlet_id
                        )
                        ->first();

                    if (!$food) {
                        throw new \RuntimeException(
                            'Food does not belong to this outlet.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Lock counter stock
                    |--------------------------------------------------------------------------
                    */

                    $pivot = DB::table('food_counter')
                        ->where('food_id', $food->id)
                        ->where('counter_id', $counter->id)
                        ->lockForUpdate()
                        ->first();


                    if (!$pivot) {
                        throw new \RuntimeException(
                            $food->food_name .
                            ' is not assigned to this counter.'
                        );
                    }


                    $available = (int) $pivot->quantity;

                    $requested = (int) $row['quantity'];


                    /*
                    |--------------------------------------------------------------------------
                    | Stock validation
                    |--------------------------------------------------------------------------
                    */

                    if ($available < $requested) {

                        throw new \RuntimeException(
                            $food->food_name .
                            ' has only ' .
                            $available .
                            ' available at Counter ' .
                            $counter->counter_number .
                            '.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Calculate line
                    |--------------------------------------------------------------------------
                    */

                    $lineTotal =
                        (float) $food->price *
                        $requested;

                    $subtotal += $lineTotal;


                    $items[] = [
                        'food' => $food,
                        'quantity' => $requested,
                        'price' => (float) $food->price,
                        'subtotal' => $lineTotal,
                    ];
                }


                /*
                |--------------------------------------------------------------------------
                | Discount
                |--------------------------------------------------------------------------
                */

                $discount = min(
                    max(
                        0,
                        (float) ($data['discount'] ?? 0)
                    ),
                    $subtotal
                );


                /*
                |--------------------------------------------------------------------------
                | Grand total
                |--------------------------------------------------------------------------
                */

                $grandTotal = max(
                    0,
                    $subtotal - $discount
                );


                /*
                |--------------------------------------------------------------------------
                | Payment
                |--------------------------------------------------------------------------
                */

                $paymentMethod = $data['payment_method'];


                $cashReceived =
                    $paymentMethod === 'cash'
                        ? (float) ($data['cash_received'] ?? 0)
                        : $grandTotal;


                if (
                    $paymentMethod === 'cash' &&
                    $cashReceived < $grandTotal
                ) {

                    throw new \RuntimeException(
                        'Cash received is less than the grand total.'
                    );
                }


                $change =
                    max(
                        0,
                        $cashReceived - $grandTotal
                    );


                /*
                |--------------------------------------------------------------------------
                | Generate token
                |--------------------------------------------------------------------------
                |
                | Example:
                | HB-0001
                | HB-0002
                |
                */

                $nextOrderId =
                    ((int) Order::max('id')) + 1;

                $token =
                    'HB-' .
                    str_pad(
                        (string) $nextOrderId,
                        4,
                        '0',
                        STR_PAD_LEFT
                    );


                /*
                |--------------------------------------------------------------------------
                | Create order
                |--------------------------------------------------------------------------
                */

                $order = Order::create([
                    'user_id' => $user->id,

                    'outlet_id' =>
                        $counter->outlet_id,

                    'counter_id' =>
                        $counter->id,

                    'token_number' =>
                        $token,

                    'order_type' =>
                        $data['order_type'],

                    'total_amount' =>
                        $subtotal,

                    'discount' =>
                        $discount,

                    'grand_total' =>
                        $grandTotal,

                    'payment_method' =>
                        $paymentMethod,

                    'cash_received' =>
                        $cashReceived,

                    'change_amount' =>
                        $change,

                    'status' =>
                        'pending',

                    'payment_status' =>
                        'paid',
                ]);


                /*
                |--------------------------------------------------------------------------
                | Create order items + reduce counter stock
                |--------------------------------------------------------------------------
                */

                foreach ($items as $item) {

                    OrderItem::create([
                        'order_id' =>
                            $order->id,

                        'food_id' =>
                            $item['food']->id,

                        'counter_id' =>
                            $counter->id,

                        'quantity' =>
                            $item['quantity'],

                        'price' =>
                            $item['price'],
                    ]);


                    DB::table('food_counter')
                        ->where(
                            'food_id',
                            $item['food']->id
                        )
                        ->where(
                            'counter_id',
                            $counter->id
                        )
                        ->decrement(
                            'quantity',
                            $item['quantity']
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | Payment
                |--------------------------------------------------------------------------
                */

                Payment::create([
                    'order_id' =>
                        $order->id,

                    'amount' =>
                        $grandTotal,

                    'payment_method' =>
                        $paymentMethod,

                    'payment_status' =>
                        'paid',

                    'cash_received' =>
                        $cashReceived,

                    'change_amount' =>
                        $change,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Kitchen Ticket
                |--------------------------------------------------------------------------
                */

                KitchenTicket::create([
                    'order_id' =>
                        $order->id,

                    'chef_id' =>
                        null,

                    'status' =>
                        'waiting',
                ]);


                /*
                |--------------------------------------------------------------------------
                | Queue number
                |--------------------------------------------------------------------------
                */

                $queueNumber =
                    (
                        QueueDisplay::whereDate(
                            'created_at',
                            today()
                        )->max('queue_number')
                        ?? 0
                    ) + 1;


                QueueDisplay::create([
                    'order_id' =>
                        $order->id,

                    'queue_number' =>
                        $queueNumber,

                    'status' =>
                        'waiting',
                ]);


                /*
                |--------------------------------------------------------------------------
                | Load relationships
                |--------------------------------------------------------------------------
                */

                $order->load([
                    'user',
                    'outlet',
                    'counter',
                    'orderItems.food',
                    'orderItems.counter',
                    'payment',
                    'kitchenTicket',
                ]);


                /*
                |--------------------------------------------------------------------------
                | Return transaction result
                |--------------------------------------------------------------------------
                */

                return [
                    'order' =>
                        $order,

                    'items' =>
                        $items,

                    'subtotal' =>
                        $subtotal,

                    'discount' =>
                        $discount,

                    'grand_total' =>
                        $grandTotal,

                    'cash_received' =>
                        $cashReceived,

                    'change' =>
                        $change,

                    'queue_number' =>
                        $queueNumber,
                ];
            }, 5);


            $order = $result['order'];


            /*
            |--------------------------------------------------------------------------
            | JSON RESPONSE
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            | Dashboard එක මේ exact response එක use කරනවා.
            |
            */

            return response()->json([
                'success' => true,

                'message' =>
                    'Bill created successfully.',

                'order_id' =>
                    $order->id,

                'token' =>
                    $order->token_number,

                'counter' =>
                    $counter->counter_number,

                'order_type' =>
                    $order->order_type,

                'subtotal' =>
                    (float) $result['subtotal'],

                'discount' =>
                    (float) $result['discount'],

                'grand_total' =>
                    (float) $result['grand_total'],

                'cash_received' =>
                    (float) $result['cash_received'],

                'change' =>
                    (float) $result['change'],

                'queue_number' =>
                    $result['queue_number'],

                /*
                |--------------------------------------------------------------------------
                | Items for receipt preview
                |--------------------------------------------------------------------------
                */

                'items' =>
                    collect($result['items'])
                        ->map(function ($item) {

                            return [
                                'food_id' =>
                                    $item['food']->id,

                                'name' =>
                                    $item['food']->food_name,

                                'quantity' =>
                                    $item['quantity'],

                                'price' =>
                                    (float) $item['price'],

                                'subtotal' =>
                                    (float) $item['subtotal'],
                            ];
                        })
                        ->values(),

                /*
                |--------------------------------------------------------------------------
                | Print URLs
                |--------------------------------------------------------------------------
                */

                'receipt_url' =>
                    route(
                        'cashier.orders.receipt',
                        $order->id
                    ),

                'kot_url' =>
                    route(
                        'cashier.orders.kot',
                        $order->id
                    ),
            ]);


        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,

                'message' =>
                    $e->getMessage(),
            ], 422);
        }
    }


    /**
     * Show order.
     */
    public function show(Order $order)
    {
        $order->load([
            'user',
            'outlet',
            'counter',
            'orderItems.food',
            'orderItems.counter',
            'payment',
            'kitchenTicket',
        ]);

        return view(
            'orders.show',
            compact('order')
        );
    }


    /**
     * Edit order.
     */
    public function edit(Order $order)
    {
        $order->load([
            'orderItems.food',
            'orderItems.counter',
            'counter',
        ]);

        return view(
            'orders.edit',
            compact('order')
        );
    }


    /**
     * Update order status.
     */
    public function update(
        Request $request,
        Order $order
    ) {

        $data = $request->validate([
            'status' =>
                'required|in:pending,accepted,preparing,ready,completed,cancelled',
        ]);

        $order->update([
            'status' =>
                $data['status'],
        ]);

        return back()->with(
            'success',
            'Order status updated.'
        );
    }


    /**
     * Cancel order.
     */
    public function destroy(Order $order)
    {
        if ($order->status !== 'cancelled') {

            $order->update([
                'status' => 'cancelled',
            ]);
        }

        return back()->with(
            'success',
            'Order cancelled.'
        );
    }


    /**
     * Receipt.
     */
    public function receipt(Order $order)
    {
        $this->checkOrderAccess($order);

        $order->load([
            'user',
            'outlet',
            'counter',
            'orderItems.food',
            'orderItems.counter',
            'payment',
        ]);

        return view(
            'cashier.print.receipt',
            compact('order')
        );
    }


    /**
     * Kitchen Order Ticket.
     */
    public function kot(Order $order)
    {
        $this->checkOrderAccess($order);

        $order->load([
            'user',
            'outlet',
            'counter',
            'orderItems.food',
            'orderItems.counter',
            'kitchenTicket',
        ]);

        return view(
            'cashier.print.kot',
            compact('order')
        );
    }


    /**
     * Check order access.
     */
    private function checkOrderAccess(Order $order)
    {
        $user = auth()->user();

        if (
            $user->role === 'admin' ||
            $user->role === 'manager'
        ) {
            return;
        }

        if (
            (int) $order->outlet_id !==
                (int) $user->outlet_id
            &&
            (int) $order->user_id !==
                (int) $user->id
        ) {
            abort(403);
        }
    }
}
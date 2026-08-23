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
use App\Events\KitchenTicketUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'user',
            'outlet',
            'counter',
            'orderItems.food',
            'orderItems.counter',
            'payment',
            'kitchenTickets.counter',
            'kitchenTickets.chef',
        ])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $outlets = Outlet::where('status', 'active')->get();

        $counters = Counter::where('status', 'active')->get();

        $foods = Food::with([
            'category',
            'counters' => function ($query) {
                $query->where('counters.status', 'active');
            },
        ])
            ->whereHas('counters', function ($query) {
                $query->where('counters.status', 'active')
                    ->where('food_counter.quantity', '>', 0);
            })
            ->get();

        return view(
            'orders.create',
            compact('foods', 'outlets', 'counters')
        );
    }

    public function store(Request $request)
    {
        return $this->cashierStore($request);
    }

    public function cashierStore(Request $request)
    {
        $data = $request->validate([
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

            'items.*.counter_id' => [
                'required',
                'integer',
                'exists:counters,id',
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

        try {
            $result = DB::transaction(function () use ($data, $user) {

                $subtotal = 0;
                $items = [];

                foreach ($data['items'] as $row) {

                    $food = Food::with('category')
                        ->whereKey($row['food_id'])
                        ->first();

                    if (!$food) {
                        throw new \RuntimeException(
                            'Food not found.'
                        );
                    }

                    $counter = Counter::whereKey($row['counter_id'])
                        ->where('status', 'active')
                        ->first();

                    if (!$counter) {
                        throw new \RuntimeException(
                            'Selected counter is not active.'
                        );
                    }

                    if (
                        $user->outlet_id &&
                        (int) $counter->outlet_id !==
                        (int) $user->outlet_id
                    ) {
                        throw new \RuntimeException(
                            'Counter does not belong to this cashier outlet.'
                        );
                    }

                    if (
                        (int) $food->outlet_id !==
                        (int) $counter->outlet_id
                    ) {
                        throw new \RuntimeException(
                            $food->food_name .
                            ' does not belong to this counter outlet.'
                        );
                    }

                    $pivot = DB::table('food_counter')
                        ->where('food_id', $food->id)
                        ->where('counter_id', $counter->id)
                        ->lockForUpdate()
                        ->first();

                    if (!$pivot) {
                        throw new \RuntimeException(
                            $food->food_name .
                            ' is not assigned to Counter ' .
                            $counter->counter_number .
                            '.'
                        );
                    }

                    $available = (int) $pivot->quantity;
                    $requested = (int) $row['quantity'];

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

                    $lineTotal =
                        (float) $food->price * $requested;

                    $subtotal += $lineTotal;

                    $items[] = [
                        'food' => $food,
                        'counter' => $counter,
                        'quantity' => $requested,
                        'price' => (float) $food->price,
                        'subtotal' => $lineTotal,
                    ];
                }

                $discount = min(
                    max(
                        0,
                        (float) ($data['discount'] ?? 0)
                    ),
                    $subtotal
                );

                $grandTotal = max(
                    0,
                    $subtotal - $discount
                );

                $paymentMethod = $data['payment_method'];

                $cashReceived = $paymentMethod === 'cash'
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

                $change = max(
                    0,
                    $cashReceived - $grandTotal
                );

                $nextOrderId =
                    ((int) Order::max('id')) + 1;

                $token = 'HB-' . str_pad(
                    (string) $nextOrderId,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

                $order = Order::create([
                    'user_id' => $user->id,

                    'outlet_id' => $user->outlet_id
                        ?? $items[0]['counter']->outlet_id,

                    'counter_id' => $items[0]['counter']->id,

                    'token_number' => $token,

                    'order_type' => $data['order_type'],

                    'total_amount' => $subtotal,

                    'discount' => $discount,

                    'grand_total' => $grandTotal,

                    'payment_method' => $paymentMethod,

                    'cash_received' => $cashReceived,

                    'change_amount' => $change,

                    'status' => 'pending',

                    'payment_status' => 'paid',
                ]);

                foreach ($items as $item) {

                    OrderItem::create([
                        'order_id' => $order->id,

                        'food_id' => $item['food']->id,

                        'counter_id' => $item['counter']->id,

                        'quantity' => $item['quantity'],

                        'price' => $item['price'],
                    ]);

                    DB::table('food_counter')
                        ->where('food_id', $item['food']->id)
                        ->where('counter_id', $item['counter']->id)
                        ->decrement(
                            'quantity',
                            $item['quantity']
                        );
                }

                Payment::create([
                    'order_id' => $order->id,

                    'amount' => $grandTotal,

                    'payment_method' => $paymentMethod,

                    'payment_status' => 'paid',

                    'cash_received' => $cashReceived,

                    'change_amount' => $change,
                ]);

                $counterIds = collect($items)
                    ->pluck('counter.id')
                    ->unique()
                    ->values();

                foreach ($counterIds as $counterId) {
                    KitchenTicket::create([
                        'order_id' => $order->id,

                        'counter_id' => $counterId,

                        'chef_id' => null,

                        'status' => 'waiting',
                    ]);
                }

                $lastQueueNumber = QueueDisplay::whereDate(
                       'created_at',
                        today()
                    )->latest('id')->value('queue_number');
                if ($lastQueueNumber) {
                $lastNumber = (int) preg_replace('/\D/', '', $lastQueueNumber);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }
                $queueNumber = 'HB-' . str_pad(
                (string) $nextNumber,
                 3,
                '0',
                STR_PAD_LEFT
            );

                QueueDisplay::create([
                    'order_id' => $order->id,

                    'queue_number' => $queueNumber,

                    'status' => 'waiting',
                ]);

                $order->load([
                    'user',
                    'outlet',
                    'counter',
                    'orderItems.food',
                    'orderItems.counter',
                    'payment',
                    'kitchenTickets.counter',
                    'kitchenTickets.chef',
                ]);

                return [
                    'order' => $order,

                    'items' => $items,

                    'subtotal' => $subtotal,

                    'discount' => $discount,

                    'grand_total' => $grandTotal,

                    'cash_received' => $cashReceived,

                    'change' => $change,

                    'queue_number' => $queueNumber,

                    'payment_method' => $paymentMethod,
                ];
            }, 5);

            $order = $result['order'];

            event(new KitchenTicketUpdated(
                $order->id,
                $order->status
            ));

            return response()->json([
                'success' => true,

                'message' => 'Bill created successfully.',

                'order_id' => $order->id,

                'token' => $order->token_number,

                'subtotal' => (float) $result['subtotal'],

                'discount' => (float) $result['discount'],

                'grand_total' => (float) $result['grand_total'],

                'payment_method' =>
                    $result['payment_method'],

                'cash_received' =>
                    (float) $result['cash_received'],

                'change' =>
                    (float) $result['change'],

                'queue_number' =>
                    $result['queue_number'],

                'items' => collect($result['items'])
                    ->map(function ($item) {

                        return [
                            'food_id' =>
                                $item['food']->id,

                            'name' =>
                                $item['food']->food_name,

                            'counter_id' =>
                                $item['counter']->id,

                            'counter_number' =>
                                $item['counter']->counter_number,

                            'quantity' =>
                                $item['quantity'],

                            'price' =>
                                (float) $item['price'],

                            'subtotal' =>
                                (float) $item['subtotal'],
                        ];
                    })
                    ->values(),

                'receipt_url' => route(
                    'cashier.orders.receipt',
                    $order->id
                ),

                'kot_url' => route(
                    'cashier.orders.kot',
                    $order->id
                ),
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,

                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function show(Order $order)
    {
        $order->load([
            'user',
            'outlet',
            'counter',
            'orderItems.food',
            'orderItems.counter',
            'payment',
            'kitchenTickets.counter',
            'kitchenTickets.chef',
        ]);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load([
            'orderItems.food',
            'orderItems.counter',
            'counter',
            'kitchenTickets.counter',
        ]);

        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => [
                'required',
                'in:pending,accepted,preparing,ready,completed,cancelled',
            ],
        ]);

        $order->update([
            'status' => $data['status'],
        ]);

        return back()->with(
            'success',
            'Order status updated.'
        );
    }

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

    public function kot(Order $order)
    {
        $this->checkOrderAccess($order);

        $order->load([
            'user',
            'outlet',
            'counter',
            'orderItems.food',
            'orderItems.counter',
            'kitchenTickets.counter',
            'kitchenTickets.chef',
        ]);

        return view(
            'cashier.print.kot',
            compact('order')
        );
    }

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
            (int) $user->outlet_id &&
            (int) $order->user_id !==
            (int) $user->id
        ) {
            abort(403);
        }
    }
}
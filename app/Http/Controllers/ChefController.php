<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use App\Models\Counter;
use App\Models\QueueDisplay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChefController extends Controller
{
    /**
     * Chef Dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Chef Counter
        |--------------------------------------------------------------------------
        */

        $counter = null;

        if ($user->counter_id) {
            $counter = Counter::with('outlet')
                ->where('id', $user->counter_id)
                ->where('status', 'active')
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | No Counter
        |--------------------------------------------------------------------------
        */

        if (!$counter) {
            return view('chef.dashboard', [
                'user'    => $user,
                'counter' => null,
                'orders'  => collect(),
                'foods'   => collect(),
                'error'   => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Orders for this Counter
        |--------------------------------------------------------------------------
        */

        $orders = Order::with([
            'orderItems.food',
            'orderItems.counter',
            'kitchenTicket',
            'payment',
        ])
            ->where('counter_id', $counter->id)
            ->whereIn('status', [
                'pending',
                'accepted',
                'preparing',
                'ready',
            ])
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Foods assigned to this Counter
        |--------------------------------------------------------------------------
        */

        $foods = Food::with([
            'category',
            'counters',
        ])
            ->where('outlet_id', $counter->outlet_id)
            ->whereHas('counters', function ($query) use ($counter) {
                $query->where(
                    'counters.id',
                    $counter->id
                );
            })
            ->get();

        return view('chef.dashboard', compact(
            'user',
            'counter',
            'orders',
            'foods'
        ));
    }


    /**
     * Update Chef Order Status
     *
     * pending
     * accepted
     * preparing
     * ready
     * completed
     */
    public function updateOrderStatus(
        Request $request,
        Order $order
    ) {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([
            'status' => [
                'required',
                'in:accepted,preparing,ready,completed',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Chef Counter Access
        |--------------------------------------------------------------------------
        */

        if (
            !$user->counter_id ||
            (int) $order->counter_id !==
            (int) $user->counter_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This order does not belong to your counter.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Status Flow Validation
        |--------------------------------------------------------------------------
        */

        $currentStatus = $order->status;
        $newStatus = $data['status'];

        $allowedTransitions = [
            'pending' => [
                'accepted',
            ],

            'accepted' => [
                'preparing',
            ],

            'preparing' => [
                'ready',
            ],

            'ready' => [
                'completed',
            ],
        ];

        if (
            !isset($allowedTransitions[$currentStatus]) ||
            !in_array(
                $newStatus,
                $allowedTransitions[$currentStatus],
                true
            )
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Invalid order status transition.',
            ], 422);
        }

        try {

            DB::transaction(function () use (
                $order,
                $newStatus,
                $user
            ) {

                /*
                |--------------------------------------------------------------------------
                | Update Order
                |--------------------------------------------------------------------------
                */

                $order->update([
                    'status' => $newStatus,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Kitchen Ticket
                |--------------------------------------------------------------------------
                */

                if ($order->kitchenTicket) {

                    $kitchenStatus = match ($newStatus) {

                        'accepted' =>
                            'accepted',

                        'preparing' =>
                            'preparing',

                        'ready' =>
                            'ready',

                        'completed' =>
                            'completed',

                        default =>
                            $order->kitchenTicket->status,
                    };

                    $order->kitchenTicket->update([
                        'status' => $kitchenStatus,
                        'chef_id' => $user->id,
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | QUEUE DISPLAY
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                |
                | Chef clicks READY
                |       ↓
                | Queue becomes READY
                |       ↓
                | Customer Queue Display can show token
                |
                */

                $queue = QueueDisplay::where(
                    'order_id',
                    $order->id
                )
                    ->lockForUpdate()
                    ->first();

                if ($queue) {

                    if ($newStatus === 'ready') {

                        $queue->update([
                            'status' => 'ready',
                        ]);

                    } elseif ($newStatus === 'completed') {

                        $queue->update([
                            'status' => 'completed',
                        ]);

                    } elseif (
                        in_array(
                            $newStatus,
                            [
                                'accepted',
                                'preparing',
                            ],
                            true
                        )
                    ) {

                        $queue->update([
                            'status' => 'waiting',
                        ]);
                    }
                }
            });


            $order->refresh();

            return response()->json([
                'success' => true,

                'message' =>
                    'Order status updated successfully.',

                'order_id' =>
                    $order->id,

                'status' =>
                    $order->status,

                'queue_status' =>
                    optional(
                        QueueDisplay::where(
                            'order_id',
                            $order->id
                        )->first()
                    )->status,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    /**
     * Update food quantity for Chef's counter.
     */
    public function updateFoodQuantity(
        Request $request,
        Food $food
    ) {
        $user = auth()->user();

        $data = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        if (!$user->counter_id) {
            return response()->json([
                'success' => false,
                'message' => 'No counter assigned.',
            ], 422);
        }

        $counter = Counter::where('id', $user->counter_id)
            ->where('status', 'active')
            ->first();

        if (!$counter) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid counter.',
            ], 422);
        }

        if (
            (int) $food->outlet_id !==
            (int) $counter->outlet_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Food does not belong to this outlet.',
            ], 403);
        }

        $pivot = DB::table('food_counter')
            ->where('food_id', $food->id)
            ->where('counter_id', $counter->id)
            ->lockForUpdate()
            ->first();

        if (!$pivot) {
            return response()->json([
                'success' => false,
                'message' =>
                    'This food is not assigned to your counter.',
            ], 422);
        }

        DB::table('food_counter')
            ->where('food_id', $food->id)
            ->where('counter_id', $counter->id)
            ->update([
                'quantity' => $data['quantity'],
                'updated_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Food quantity updated.',
            'food_id' => $food->id,
            'quantity' => (int) $data['quantity'],
            'available' => (int) $data['quantity'] > 0,
        ]);
    }


    /**
     * Chef data endpoint.
     */
    public function data()
    {
        $user = auth()->user();

        if (!$user->counter_id) {
            return response()->json([
                'orders' => [],
            ]);
        }

        $orders = Order::with([
            'orderItems.food',
            'kitchenTicket',
        ])
            ->where('counter_id', $user->counter_id)
            ->whereIn('status', [
                'pending',
                'accepted',
                'preparing',
                'ready',
            ])
            ->latest()
            ->get();

        return response()->json([
            'orders' => $orders,
        ]);
    }
}
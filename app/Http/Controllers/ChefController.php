<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use App\Models\Counter;
use App\Models\QueueDisplay;
use App\Models\KitchenTicket;
use App\Events\FoodInventoryUpdated;
use App\Events\KitchenTicketUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChefController extends Controller
{
    // Chef dashboard
    public function dashboard()
    {
        $user = auth()->user();

        $counter = Counter::with('outlet')
            ->where('id', $user->counter_id)
            ->where('status', 'active')
            ->first();

        if (!$counter) {
            return view('chef.dashboard', [
                'user' => $user,
                'counter' => null,
                'orders' => collect(),
                'foods' => collect(),
                'error' => true,
            ]);
        }

        $orders = $this->getChefOrders($counter);

        $foods = Food::with([
            'category',
            'counters' => function ($query) use ($counter) {
                $query->where('counters.id', $counter->id);
            },
        ])
            ->where('outlet_id', $counter->outlet_id)
            ->whereHas('counters', function ($query) use ($counter) {
                $query->where('counters.id', $counter->id);
            })
            ->orderBy('food_name')
            ->get();

        return view('chef.dashboard', [
            'user' => $user,
            'counter' => $counter,
            'orders' => $orders,
            'foods' => $foods,
        ]);
    }


    // Update ticket status
    public function updateOrderStatus(Request $request, Order $order)
    {
        $user = auth()->user();

        $data = $request->validate([
            'status' => [
                'required',
                'in:accepted,preparing,ready,completed',
            ],
        ]);

        $counter = Counter::where('id', $user->counter_id)
            ->where('status', 'active')
            ->first();

        if (!$counter) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid chef counter.',
            ], 403);
        }

        if ((int) $order->outlet_id !== (int) $counter->outlet_id) {
            return response()->json([
                'success' => false,
                'message' => 'This order does not belong to your outlet.',
            ], 403);
        }

        $ticket = KitchenTicket::where('order_id', $order->id)
            ->where('counter_id', $counter->id)
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'This order does not belong to your counter.',
            ], 403);
        }

        $newStatus = $data['status'];

        // Correct ticket transitions
        $allowed = [
            'accepted' => ['waiting'],
            'preparing' => ['waiting'],
            'ready' => ['cooking'],
            'completed' => ['ready'],
        ];

        if (
            !isset($allowed[$newStatus]) ||
            !in_array($ticket->status, $allowed[$newStatus], true)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status transition.',
            ], 422);
        }

        try {

            DB::transaction(function () use (
                $order,
                $ticket,
                $newStatus,
                $user,
                $counter
            ) {

                // Accept
                if ($newStatus === 'accepted') {

                    $ticket->update([
                        'status' => 'waiting',
                        'chef_id' => $user->id,
                    ]);

                    $this->updateOrderOverallStatus($order);
                }


                // Preparing
                elseif ($newStatus === 'preparing') {

                    $ticket->update([
                        'status' => 'cooking',
                        'chef_id' => $user->id,
                    ]);

                    $this->updateOrderOverallStatus($order);
                }


                // Ready
                elseif ($newStatus === 'ready') {

                    // IMPORTANT:
                    // Ready is NOT completed yet.
                    $ticket->update([
                        'status' => 'ready',
                        'chef_id' => $user->id,
                    ]);

                    /*
                     * Queue එකට යවන්නේ order එකේ
                     * සියලු counters ready/completed නම් විතරයි.
                     */
                    $allReady = !KitchenTicket::where(
                        'order_id',
                        $order->id
                    )
                        ->whereNotIn('status', [
                            'ready',
                            'completed',
                        ])
                        ->exists();

                    if ($allReady) {

                        QueueDisplay::updateOrCreate(
                            [
                                'order_id' => $order->id,
                            ],
                            [
                                'counter_id' => $counter->id,
                                'kitchen_ticket_id' => $ticket->id,
                                'queue_number' => $order->token_number,
                                'status' => 'ready',
                            ]
                        );

                        $order->update([
                            'status' => 'ready',
                        ]);

                    } else {

                        $this->updateOrderOverallStatus($order);
                    }
                }


                // Complete / Served
                elseif ($newStatus === 'completed') {

                    // This counter is now served
                    $ticket->update([
                        'status' => 'completed',
                        'chef_id' => $user->id,
                    ]);

                    /*
                     * සියලු counters complete ද බලනවා.
                     */
                    $allCompleted = !KitchenTicket::where(
                        'order_id',
                        $order->id
                    )
                        ->where('status', '!=', 'completed')
                        ->exists();

                    if ($allCompleted) {

                        // Remove queue only now
                        QueueDisplay::where(
                            'order_id',
                            $order->id
                        )->delete();

                        $order->update([
                            'status' => 'completed',
                        ]);

                    } else {

                        // Still waiting for other counters
                        $order->update([
                            'status' => 'ready',
                        ]);
                    }
                }
            });


            $order->refresh();

            event(new KitchenTicketUpdated(
                $order->id,
                $order->status
            ));

            return response()->json([
                'success' => true,
                'message' => 'Kitchen ticket updated successfully.',
                'order_id' => $order->id,
                'status' => $order->status,
                'counter_id' => $counter->id,
                'ticket_status' => $ticket->fresh()->status,
                'queue_status' => QueueDisplay::where(
                    'order_id',
                    $order->id
                )->value('status'),
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    // Overall order status
    private function updateOrderOverallStatus(Order $order)
    {
        $tickets = KitchenTicket::where(
            'order_id',
            $order->id
        )->get();

        if ($tickets->isEmpty()) {
            return;
        }


        // All counters completed
        if ($tickets->every(
            fn ($ticket) => $ticket->status === 'completed'
        )) {

            $order->update([
                'status' => 'completed',
            ]);

            return;
        }


        // All counters ready or completed
        if ($tickets->every(
            fn ($ticket) =>
                in_array($ticket->status, [
                    'ready',
                    'completed',
                ], true)
        )) {

            $order->update([
                'status' => 'ready',
            ]);

            return;
        }


        // At least one is cooking
        if ($tickets->contains(
            fn ($ticket) => $ticket->status === 'cooking'
        )) {

            $order->update([
                'status' => 'preparing',
            ]);

            return;
        }


        // Otherwise accepted
        $order->update([
            'status' => 'accepted',
        ]);
    }


    // Complete order
    public function completeOrder(Order $order)
    {
        $user = auth()->user();

        $counter = Counter::where('id', $user->counter_id)
            ->where('status', 'active')
            ->first();

        if (!$counter) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid chef counter.',
            ], 403);
        }

        if ((int) $order->outlet_id !== (int) $counter->outlet_id) {
            return response()->json([
                'success' => false,
                'message' => 'This order does not belong to your outlet.',
            ], 403);
        }

        $ticket = KitchenTicket::where('order_id', $order->id)
            ->where('counter_id', $counter->id)
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'This order does not belong to your counter.',
            ], 403);
        }


        // Complete is allowed only after Ready
        if ($ticket->status !== 'ready') {
            return response()->json([
                'success' => false,
                'message' => 'Your counter ticket is not ready yet.',
            ], 422);
        }


        try {

            DB::transaction(function () use (
                $order,
                $ticket,
                $counter
            ) {

                // Mark this counter as completed
                $ticket->update([
                    'status' => 'completed',
                ]);


                // Check remaining counters
                $remaining = KitchenTicket::where(
                    'order_id',
                    $order->id
                )
                    ->where('status', '!=', 'completed')
                    ->exists();


                if (!$remaining) {

                    // Every counter completed
                    QueueDisplay::where(
                        'order_id',
                        $order->id
                    )->delete();

                    $order->update([
                        'status' => 'completed',
                    ]);

                } else {

                    // Other counters still need to complete
                    $order->update([
                        'status' => 'ready',
                    ]);
                }
            });


            $order->refresh();

            event(new KitchenTicketUpdated(
                $order->id,
                $order->status
            ));

            return response()->json([
                'success' => true,
                'message' => 'Order completed successfully.',
                'order_id' => $order->id,
                'status' => $order->status,
                'counter_id' => $counter->id,
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    // Update food quantity
    public function updateFoodQuantity(Request $request, Food $food)
    {
        $user = auth()->user();

        $data = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $counter = Counter::where('id', $user->counter_id)
            ->where('status', 'active')
            ->first();

        if (!$counter) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid counter.',
            ], 422);
        }

        if ((int) $food->outlet_id !== (int) $counter->outlet_id) {
            return response()->json([
                'success' => false,
                'message' => 'Food does not belong to this outlet.',
            ], 403);
        }

        try {

            DB::transaction(function () use (
                $food,
                $counter,
                $data
            ) {

                $pivot = DB::table('food_counter')
                    ->where('food_id', $food->id)
                    ->where('counter_id', $counter->id)
                    ->lockForUpdate()
                    ->first();

                if (!$pivot) {
                    throw new \RuntimeException(
                        'This food is not assigned to your counter.'
                    );
                }

                DB::table('food_counter')
                    ->where('food_id', $food->id)
                    ->where('counter_id', $counter->id)
                    ->update([
                        'quantity' => (int) $data['quantity'],
                        'updated_at' => now(),
                    ]);
            });


            event(new FoodInventoryUpdated(
                $food->id,
                $counter->id,
                (int) $data['quantity']
            ));

            return response()->json([
                'success' => true,
                'food_id' => $food->id,
                'counter_id' => $counter->id,
                'quantity' => (int) $data['quantity'],
                'available' => (int) $data['quantity'] > 0,
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    // Chef live data
    public function data()
    {
        $user = auth()->user();

        $counter = Counter::where('id', $user->counter_id)
            ->where('status', 'active')
            ->first();

        if (!$counter) {
            return response()->json([
                'orders' => [],
            ]);
        }

        return response()->json([
            'orders' => $this->getChefOrders($counter),
        ]);
    }


    // Get today's orders for chef counter
    private function getChefOrders(Counter $counter)
    {
        $orders = Order::with([
            'orderItems.food',
            'orderItems.counter',
            'kitchenTickets.counter',
            'kitchenTickets.chef',
            'payment',
            'counter',
        ])
            ->where('outlet_id', $counter->outlet_id)
            ->whereDate('created_at', today())

            ->whereHas('kitchenTickets', function ($query) use ($counter) {
                $query->where('counter_id', $counter->id);
            })

            ->whereIn('status', [
                'pending',
                'accepted',
                'preparing',
                'ready',
            ])

            ->latest()
            ->get();


        $orders->each(function ($order) use ($counter) {

            $ticket = $order->kitchenTickets
                ->firstWhere('counter_id', $counter->id);

            $order->myTicketStatus = $ticket?->status;
        });


        return $orders;
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\KitchenTicket;
use App\Models\Order;
use App\Models\User;
use App\Models\Counter;
use Illuminate\Http\Request;

class KitchenTicketController extends Controller
{
    public function index()
    {
        $kitchenTickets = KitchenTicket::with([
            'order',
            'counter',
            'chef'
        ])
            ->latest()
            ->get();

        return view(
            'kitchen_tickets.index',
            compact('kitchenTickets')
        );
    }

    public function create()
    {
        $orders = Order::with([
            'orderItems.counter'
        ])
            ->latest()
            ->get();

        $chefs = User::where(
            'role',
            'chef'
        )->get();

        $counters = Counter::where(
            'status',
            'active'
        )
            ->orderBy('counter_number')
            ->get();

        return view(
            'kitchen_tickets.create',
            compact(
                'orders',
                'chefs',
                'counters'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => [
                'required',
                'exists:orders,id'
            ],

            'counter_id' => [
                'required',
                'exists:counters,id'
            ],

            'chef_id' => [
                'nullable',
                'exists:users,id'
            ],

            'status' => [
                'required'
            ],
        ]);

        $order = Order::findOrFail(
            $request->order_id
        );

        $counter = Counter::findOrFail(
            $request->counter_id
        );

        if (
            (int) $order->outlet_id !==
            (int) $counter->outlet_id
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'counter_id' =>
                        'Counter does not belong to this outlet.'
                ]);
        }

        $existingTicket = KitchenTicket::where(
            'order_id',
            $order->id
        )
            ->where(
                'counter_id',
                $counter->id
            )
            ->first();

        if ($existingTicket) {
            return back()
                ->withInput()
                ->withErrors([
                    'counter_id' =>
                        'This order already has a kitchen ticket for this counter.'
                ]);
        }

        KitchenTicket::create([
            'order_id' => $order->id,
            'counter_id' => $counter->id,
            'chef_id' => $request->chef_id,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('kitchen-tickets.index')
            ->with(
                'success',
                'Kitchen ticket created successfully.'
            );
    }

    public function show(string $id)
    {
        $kitchenTicket = KitchenTicket::with([
            'order',
            'counter',
            'chef'
        ])
            ->findOrFail($id);

        return view(
            'kitchen_tickets.show',
            compact('kitchenTicket')
        );
    }

    public function edit(string $id)
    {
        $kitchenTicket = KitchenTicket::findOrFail(
            $id
        );

        $orders = Order::with([
            'orderItems.counter'
        ])
            ->latest()
            ->get();

        $chefs = User::where(
            'role',
            'chef'
        )->get();

        $counters = Counter::where(
            'status',
            'active'
        )
            ->orderBy('counter_number')
            ->get();

        return view(
            'kitchen_tickets.edit',
            compact(
                'kitchenTicket',
                'orders',
                'chefs',
                'counters'
            )
        );
    }

    public function update(
        Request $request,
        string $id
    ) {
        $request->validate([
            'order_id' => [
                'required',
                'exists:orders,id'
            ],

            'counter_id' => [
                'required',
                'exists:counters,id'
            ],

            'chef_id' => [
                'nullable',
                'exists:users,id'
            ],

            'status' => [
                'required'
            ],
        ]);

        $kitchenTicket = KitchenTicket::findOrFail(
            $id
        );

        $order = Order::findOrFail(
            $request->order_id
        );

        $counter = Counter::findOrFail(
            $request->counter_id
        );

        if (
            (int) $order->outlet_id !==
            (int) $counter->outlet_id
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'counter_id' =>
                        'Counter does not belong to this outlet.'
                ]);
        }

        $duplicate = KitchenTicket::where(
            'order_id',
            $order->id
        )
            ->where(
                'counter_id',
                $counter->id
            )
            ->where(
                'id',
                '!=',
                $kitchenTicket->id
            )
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'counter_id' =>
                        'This order already has a kitchen ticket for this counter.'
                ]);
        }

        $kitchenTicket->update([
            'order_id' => $order->id,
            'counter_id' => $counter->id,
            'chef_id' => $request->chef_id,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('kitchen-tickets.index')
            ->with(
                'success',
                'Kitchen ticket updated successfully.'
            );
    }

    public function destroy(string $id)
    {
        $kitchenTicket = KitchenTicket::findOrFail(
            $id
        );

        $kitchenTicket->delete();

        return redirect()
            ->route('kitchen-tickets.index')
            ->with(
                'success',
                'Kitchen ticket deleted successfully.'
            );
    }
}
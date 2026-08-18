<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class QueueDisplayController extends Controller
{
    /**
     * Display current queue orders.
     *
     * Orders shown:
     * preparing
     * ready
     */
    public function index(Request $request)
    {
        $query = Order::with([
            'counter',
            'outlet'
        ])
        ->whereIn('status', [
            'preparing',
            'ready'
        ])
        ->latest();

        /*
        |--------------------------------------------------------------------------
        | Optional outlet filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('outlet_id')) {
            $query->where(
                'outlet_id',
                $request->integer('outlet_id')
            );
        }

        $orders = $query->get();

        return view(
            'queue.display',
            compact('orders')
        );
    }


    /**
     * Return current queue data as JSON.
     *
     * Used by AJAX / WebSocket refresh.
     */
    public function data(Request $request)
    {
        $query = Order::with([
            'counter',
            'outlet'
        ])
        ->whereIn('status', [
            'preparing',
            'ready'
        ])
        ->latest();

        /*
        |--------------------------------------------------------------------------
        | Optional outlet filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('outlet_id')) {
            $query->where(
                'outlet_id',
                $request->integer('outlet_id')
            );
        }

        $orders = $query->get();

        return response()->json([
            'orders' => $orders
                ->map(function ($order) {
                    return [
                        'id' => $order->id,

                        'token' =>
                            $order->token_number,

                        'status' =>
                            $order->status,

                        'counter' =>
                            $order->counter?->counter_number,

                        'outlet' =>
                            $order->outlet?->outlet_name,
                    ];
                })
                ->values(),
        ]);
    }
}
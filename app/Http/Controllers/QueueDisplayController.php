<?php

namespace App\Http\Controllers;

use App\Models\QueueDisplay;
use Illuminate\Http\Request;

class QueueDisplayController extends Controller
{
    // Queue display page
    public function index(Request $request)
    {
        $query = QueueDisplay::with([
            'order',
            'counter',
        ])
            ->where('status', 'ready')
            ->latest();

        // Outlet filter
        if ($request->filled('outlet_id')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where(
                    'outlet_id',
                    $request->integer('outlet_id')
                );
            });
        }

        return view('queue.display', [
            'orders' => $query->get(),
        ]);
    }


    // Queue live data
    public function data(Request $request)
    {
        $query = QueueDisplay::with([
            'order',
            'counter',
        ])
            ->where('status', 'ready')
            ->latest();

        // Outlet filter
        if ($request->filled('outlet_id')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where(
                    'outlet_id',
                    $request->integer('outlet_id')
                );
            });
        }

        $queueDisplays = $query->get();

        return response()->json([
            'orders' => $queueDisplays->map(function ($queue) {

                return [
                    'queue_display_id' => $queue->id,
                    'order_id' => $queue->order_id,
                    'token' => $queue->order?->token_number,
                    'counter_id' => $queue->counter_id,
                    'counter' =>
                        $queue->counter?->counter_number
                        ?? $queue->counter?->counter_name
                        ?? '—',
                    'status' => $queue->status,
                ];

            })->values(),
        ]);
    }
}
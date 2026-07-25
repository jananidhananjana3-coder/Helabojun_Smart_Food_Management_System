<?php

namespace App\Http\Controllers;

use App\Models\QueueDisplay;
use App\Models\Order;
use Illuminate\Http\Request;

class QueueDisplayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $queueDisplays = QueueDisplay::with('order')->get();

        return view('queue_displays.index', compact('queueDisplays'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::all();

        return view('queue_displays.create', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id'=>'required',
            'queue_number'=>'required',
            'status'=>'required',
        ]);


        QueueDisplay::create([
            'order_id'=>$request->order_id,
            'queue_number'=>$request->queue_number,
            'status'=>$request->status,
        ]);


        return redirect()->route('queue-displays.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $queueDisplay = QueueDisplay::with('order')->findOrFail($id);

        return view('queue_displays.show', compact('queueDisplay'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $queueDisplay = QueueDisplay::findOrFail($id);

        $orders = Order::all();

        return view('queue_displays.edit', compact('queueDisplay','orders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $queueDisplay = QueueDisplay::findOrFail($id);


        $queueDisplay->update([
            'order_id'=>$request->order_id,
            'queue_number'=>$request->queue_number,
            'status'=>$request->status,
        ]);


        return redirect()->route('queue-displays.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $queueDisplay = QueueDisplay::findOrFail($id);

        $queueDisplay->delete();

        return redirect()->route('queue-displays.index');
    }
}

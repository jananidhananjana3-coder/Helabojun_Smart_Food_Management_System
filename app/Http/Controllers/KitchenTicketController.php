<?php

namespace App\Http\Controllers;

use App\Models\KitchenTicket;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class KitchenTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kitchenTickets = KitchenTicket::with([
        'order',
        'chef'
    ])->get();

    return view('kitchen_tickets.index', compact('kitchenTickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::all();

    $chefs = User::where('role', 'chef')->get();

    return view('kitchen_tickets.create', compact('orders', 'chefs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
        'order_id' => 'required',
        'chef_id' => 'nullable',
        'status' => 'required',
    ]);

    KitchenTicket::create([
        'order_id' => $request->order_id,
        'chef_id' => $request->chef_id,
        'status' => $request->status,
    ]);

    return redirect()->route('kitchen-tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kitchenTicket = KitchenTicket::with([
        'order',
        'chef'
    ])->findOrFail($id);

    return view('kitchen_tickets.show', compact('kitchenTicket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kitchenTicket = KitchenTicket::findOrFail($id);

    $orders = Order::all();

    $chefs = User::where('role', 'chef')->get();

    return view('kitchen_tickets.edit', compact(
        'kitchenTicket',
        'orders',
        'chefs'
    ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kitchenTicket = KitchenTicket::findOrFail($id);

    $kitchenTicket->update([
        'chef_id' => $request->chef_id,
        'status' => $request->status,
    ]);

    return redirect()->route('kitchen-tickets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kitchenTicket = KitchenTicket::findOrFail($id);

    $kitchenTicket->delete();

    return redirect()->route('kitchen-tickets.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use App\Models\Outlet;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with([
            'user',
            'outlet',
            'orderItems.food'
        ])->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $foods = Food::all();

        $outlets = Outlet::all();

        return view('orders.create', compact('foods', 'outlets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    
        $request->validate([

            'outlet_id' => 'required',

            'food_id' => 'required',

            'quantity' => 'required',

        ]);



        // Create Order

        $order = Order::create([

            'user_id' => 1,

            'outlet_id' => $request->outlet_id,

            'token_number' => rand(100,999),

            'total_amount' => 0,

            'status' => 'pending',

            'payment_status' => 'unpaid',

        ]);



        // Get Food Price

        $food = Food::find($request->food_id);



        $total = $food->price * $request->quantity;



        // Create Order Item

        OrderItem::create([

            'order_id' => $order->id,

            'food_id' => $food->id,

            'quantity' => $request->quantity,

            'price' => $food->price,

        ]);



        // Update Total Amount

        $order->update([

            'total_amount' => $total

        ]);



        return redirect()->route('orders.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with([
            'orderItems.food'
        ])->findOrFail($id);


        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);


        $order->update([

            'status' => $request->status,

            'payment_status' => $request->payment_status,

        ]);


        return redirect()->route('orders.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);


        $order->delete();


        return redirect()->route('orders.index');

    }
}


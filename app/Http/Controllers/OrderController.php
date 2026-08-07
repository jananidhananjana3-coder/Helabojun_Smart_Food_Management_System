<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use App\Models\Outlet;
use App\Models\OrderItem;
use App\Models\KitchenTicket;
use App\Models\Counter;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with([
            'user',
            'outlet',
            'counter',
            'orderItems.food'
        ])->get();

        return view('orders.index', compact('orders'));
    }



    public function create()
    {
        $foods = Food::where('available_quantity', '>', 0)->get();

        $outlets = Outlet::all();

        $counters = Counter::where('status','active')->get();

        return view('orders.create', compact(
            'foods',
            'outlets',
            'counters'
        ));
    }




    public function store(Request $request)
    {

        $request->validate([

            'outlet_id' => 'required',

            'food_id' => 'required',

            'quantity' => 'required|integer|min:1',

            'counter_id' => 'required',

        ]);




        // Get Food

        $food = Food::findOrFail($request->food_id);




        // Check Available Quantity

        if($request->quantity > $food->available_quantity)
        {
            return back()->with(
                'error',
                'Not enough food quantity available'
            );
        }



        // Create Order

        $order = Order::create([

            'user_id' => auth()->id(),

            'outlet_id' => $request->outlet_id,

            'counter_id' => $request->counter_id,

            'token_number' => rand(100,999),

            'total_amount' => 0,

            'status' => 'pending',

            'payment_status' => 'unpaid',

        ]);






        // Create Order Item

        OrderItem::create([

            'order_id' => $order->id,

            'food_id' => $food->id,

            'quantity' => $request->quantity,

            'price' => $food->price,

        ]);



        // Reduce Available Food Quantity

        $food->decrement(

            'available_quantity',

            $request->quantity

        );



        // Update Total Amount

        $order->update([

            'total_amount' => $food->price * $request->quantity

        ]);



        // Create Kitchen Ticket

        KitchenTicket::create([

            'order_id' => $order->id,

            'status' => 'waiting',

        ]);



        return redirect()

            ->route('orders.index')

            ->with(
                'success',
                'Order created successfully'
            );

    }


    public function show(string $id)
    {

        $order = Order::with([

            'orderItems.food',
            'counter',
            'outlet'

        ])->findOrFail($id);



        return view('orders.show', compact('order'));

    }


    public function edit(string $id)
    {

        $order = Order::findOrFail($id);


        return view('orders.edit', compact('order'));

    }


    public function update(Request $request, string $id)
    {

        $order = Order::findOrFail($id);



        $order->update([

            'status' => $request->status,

            'payment_status' => $request->payment_status,

        ]);



        return redirect()->route('orders.index');

    }



    public function destroy(string $id)
    {

        $order = Order::findOrFail($id);



        $order->delete();



        return redirect()->route('orders.index');

    }

}
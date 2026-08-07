<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index()
    {
        $payments = Payment::with('order')->get();

        return view('payments.index', compact('payments'));
    }



    public function create()
    {
        $orders = Order::where('status','!=','cancelled')->get();

        return view('payments.create', compact('orders'));
    }



    public function store(Request $request)
    {

        $request->validate([

            'order_id' => 'required',

            'amount' => 'required|numeric',

            'payment_method' => 'required',

            'payment_status' => 'required',

            'cash_received' => 'nullable|numeric',

        ]);



        $change = 0;


        if($request->payment_method == 'cash')
        {

            $change = $request->cash_received - $request->amount;

        }



        Payment::create([

            'order_id' => $request->order_id,

            'amount' => $request->amount,

            'payment_method' => $request->payment_method,

            'payment_status' => $request->payment_status,

            'cash_received' => $request->cash_received ?? 0,

            'change_amount' => $change,

        ]);



        return redirect()
            ->route('payments.index')
            ->with('success','Payment completed successfully');

    }





    public function show(string $id)
    {

        $payment = Payment::with([
            'order.orderItems.food',
            'order.counter'
        ])->findOrFail($id);


        return view('payments.show', compact('payment'));

    }





    public function edit(string $id)
    {

        $payment = Payment::findOrFail($id);

        return view('payments.edit', compact('payment'));

    }





    public function update(Request $request, string $id)
    {

        $payment = Payment::findOrFail($id);



        $change = 0;


        if($request->payment_method == 'cash')
        {
            $change = $request->cash_received - $request->amount;
        }



        $payment->update([

            'amount' => $request->amount,

            'payment_method' => $request->payment_method,

            'payment_status' => $request->payment_status,

            'cash_received' => $request->cash_received ?? 0,

            'change_amount' => $change,

        ]);



        return redirect()->route('payments.index');

    }





    public function destroy(string $id)
    {

        $payment = Payment::findOrFail($id);

        $payment->delete();


        return redirect()->route('payments.index');

    }

}
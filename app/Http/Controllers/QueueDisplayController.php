<?php

namespace App\Http\Controllers;

use App\Models\Order;

class QueueDisplayController extends Controller
{

    public function index()
    {

        $readyOrders = Order::with([
            'counter',
            'outlet'
        ])
        ->where('status','ready')
        ->latest()
        ->get();


        return view('queue.display',compact(
            'readyOrders'
        ));

    }

}
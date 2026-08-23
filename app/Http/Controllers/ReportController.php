<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Outlet;
use App\Models\Counter;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input(
            'from',
            now()->toDateString()
        );

        $to = $request->input(
            'to',
            now()->toDateString()
        );

        $query = Order::with([
            'user',
            'outlet',
            'counter',
            'orderItems.food',
            'payment',
            'kitchenTickets',
        ])
        ->whereBetween('created_at', [
            $from . ' 00:00:00',
            $to . ' 23:59:59',
        ])
        ->where('payment_status', 'paid');


        /*
        |--------------------------------------------------------------------------
        | Outlet Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('outlet_id')) {
            $query->where(
                'outlet_id',
                $request->integer('outlet_id')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Counter Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('counter_id')) {
            $query->where(
                'counter_id',
                $request->integer('counter_id')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Chef Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('chef_id')) {

            $chefId = $request->integer('chef_id');

            $query->whereHas(
                'kitchenTickets',
                function ($q) use ($chefId) {
                    $q->where(
                        'chef_id',
                        $chefId
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Payment Method Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('payment_method')) {
            $query->where(
                'payment_method',
                $request->payment_method
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */

        $orders = $query
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Total Sales
        |--------------------------------------------------------------------------
        */

        $sales = $orders->sum(
            fn ($order) =>
                (float) $order->grand_total
        );


        /*
        |--------------------------------------------------------------------------
        | Payment Method Sales
        |--------------------------------------------------------------------------
        */

        $cash = $orders
            ->where('payment_method', 'cash')
            ->sum(
                fn ($order) =>
                    (float) $order->grand_total
            );

        $card = $orders
            ->where('payment_method', 'card')
            ->sum(
                fn ($order) =>
                    (float) $order->grand_total
            );

        $qr = $orders
            ->where('payment_method', 'qr')
            ->sum(
                fn ($order) =>
                    (float) $order->grand_total
            );


        /*
        |--------------------------------------------------------------------------
        | Food Sales
        |--------------------------------------------------------------------------
        */

        $foodSales = [];

        foreach ($orders as $order) {

            foreach ($order->orderItems as $item) {

                $name = $item->food?->food_name ?? 'Unknown Food';

                $foodSales[$name] =
                    ($foodSales[$name] ?? 0)
                    +
                    (
                        (float) $item->price
                        *
                        (int) $item->quantity
                    );
            }
        }

        arsort($foodSales);


        /*
        |--------------------------------------------------------------------------
        | Filter Data
        |--------------------------------------------------------------------------
        */

        $outlets = Outlet::orderBy(
            'outlet_name'
        )->get();

        $counters = Counter::orderBy(
            'counter_number'
        )->get();

        $chefs = User::where(
            'role',
            'chef'
        )
        ->orderBy('name')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Report View
        |--------------------------------------------------------------------------
        */

        return view(
            'reports.index',
            compact(
                'orders',
                'sales',
                'cash',
                'card',
                'qr',
                'foodSales',
                'outlets',
                'counters',
                'chefs',
                'from',
                'to'
            )
        );
    }
}
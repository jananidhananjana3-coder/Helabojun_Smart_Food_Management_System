<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Food;
use App\Models\User;
use App\Models\Outlet;
use App\Models\KitchenTicket;
use App\Models\Payment;
use App\Models\Counter;

class DashboardController extends Controller
{


    public function admin()
    {

        $totalOrders = Order::count();


        $todayOrders = Order::whereDate(
            'created_at',
            today()
        )->count();



        $todaySales = Payment::whereDate(
            'created_at',
            today()
        )->sum('amount');



        $pendingOrders = Order::where(
            'status',
            'pending'
        )->count();



        $completedOrders = Order::where(
            'status',
            'completed'
        )->count();



        $totalStaff = User::count();


        $totalFoods = Food::count();


        $totalOutlets = Outlet::count();



        $recentOrders = Order::latest()
            ->take(5)
            ->get();



        return view('admin.dashboard',compact(

            'totalOrders',
            'todayOrders',
            'todaySales',
            'pendingOrders',
            'completedOrders',
            'totalStaff',
            'totalFoods',
            'totalOutlets',
            'recentOrders'

        ));


    }





        public function cashier()
    {
        $user = auth()->user();

        // Cashier's assigned outlet
        $outlet = Outlet::find($user->outlet_id);

        // Counters belonging to cashier's outlet
        $counters = Counter::where('outlet_id', $user->outlet_id)
        ->where('status', 'active')
        ->with([
            'foods' => function ($query) {
                $query->wherePivot('quantity', '>', 0)
                    ->with('category');
            }
        ])
        ->orderByRaw('CAST(counter_number AS UNSIGNED)')
        ->get();

        // Today's orders
        $todayOrders = Order::whereDate(
            'created_at',
            today()
        )->count();

        // Today's sales
        $todaySales = Payment::whereDate(
            'created_at',
            today()
        )->sum('amount');

        // Recent orders
        $recentOrders = Order::whereDate(
            'created_at',
            today()
        )
            ->latest()
            ->get();

        return view('cashier.dashboard', compact(
            'outlet',
            'counters',
            'recentOrders',
            'todayOrders',
            'todaySales'
        ));
    }





            public function chef()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | CHEF COUNTER
        |--------------------------------------------------------------------------
        */

        $counter = null;

        if ($user->counter_id) {

            $counter = Counter::with([
                'foods.category'
            ])
            ->where('id', $user->counter_id)
            ->where('status', 'active')
            ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | FOODS ASSIGNED TO CHEF'S COUNTER
        |--------------------------------------------------------------------------
        */

        $foods = $counter
            ? $counter->foods
            : collect();


        /*
        |--------------------------------------------------------------------------
        | ORDERS FOR THIS COUNTER
        |--------------------------------------------------------------------------
        */

        $orders = $counter
            ? Order::with([
                'orderItems.food'
            ])
            ->where('counter_id', $counter->id)
            ->whereIn('status', [
                'pending',
                'preparing',
                'ready'
            ])
            ->latest()
            ->get()
            : collect();


        /*
        |--------------------------------------------------------------------------
        | COUNTS
        |--------------------------------------------------------------------------
        */

        $newOrders = $orders
            ->where('status', 'pending')
            ->count();


        $preparingOrders = $orders
            ->where('status', 'preparing')
            ->count();


        $completedOrders = $orders
            ->where('status', 'ready')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'chef.dashboard',
            compact(
                'user',
                'counter',
                'foods',
                'orders',
                'newOrders',
                'preparingOrders',
                'completedOrders'
            )
        );
    }


}
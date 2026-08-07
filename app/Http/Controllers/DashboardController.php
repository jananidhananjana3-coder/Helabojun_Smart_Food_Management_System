<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Food;
use App\Models\User;
use App\Models\Outlet;
use App\Models\KitchenTicket;
use App\Models\Payment;

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

        $todayOrders = Order::whereDate(
            'created_at',
            today()
        )->count();



        $todaySales = Payment::whereDate(
            'created_at',
            today()
        )->sum('amount');



        return view('cashier.dashboard',compact(

            'todayOrders',
            'todaySales'

        ));


    }





    public function chef()
    {

        $newOrders = KitchenTicket::where(
            'status',
            'waiting'
        )->count();



        $preparingOrders = KitchenTicket::where(
            'status',
            'cooking'
        )->count();



        $completedOrders = KitchenTicket::where(
            'status',
            'completed'
        )->count();



        return view('chef.dashboard',compact(

            'newOrders',
            'preparingOrders',
            'completedOrders'

        ));


    }


}
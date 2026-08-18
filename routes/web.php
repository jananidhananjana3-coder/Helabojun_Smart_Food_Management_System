<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KitchenTicketController;
use App\Http\Controllers\QueueDisplayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerDisplayController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\ReportController;


// Home Page
Route::get('/', function () {
    return view('index');
});


// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Admin Dashboard
    Route::get(
        '/admin-dashboard',
        [DashboardController::class, 'admin']
    )
        ->middleware('role:admin,manager')
        ->name('admin.dashboard');


    // Cashier Dashboard
    Route::get(
        '/cashier-dashboard',
        [DashboardController::class, 'cashier']
    )
        ->middleware('role:cashier')
        ->name('cashier.dashboard');


    // Chef Dashboard
    Route::get(
        '/chef-dashboard',
        [ChefController::class, 'dashboard']
    )
        ->middleware('role:chef')
        ->name('chef.dashboard');


    // Default Dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');


    // Profile
    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');


    // Admin and Manager Routes
    Route::middleware('role:admin,manager')->group(function () {

        // Outlet Management
        Route::resource(
            'outlets',
            OutletController::class
        );


        // Counter Management
        Route::resource(
            'counters',
            CounterController::class
        )->except([
            'show'
        ]);


        // Food Management
        Route::resource(
            'foods',
            FoodController::class
        );


        // Category Management
        Route::resource(
            'categories',
            CategoryController::class
        );


        // Order Management
        Route::resource(
            'orders',
            OrderController::class
        );


        // Payment Management
        Route::resource(
            'payments',
            PaymentController::class
        );


        // Kitchen Ticket Management
        Route::resource(
            'kitchen-tickets',
            KitchenTicketController::class
        );


        // User Management
        Route::resource(
            'users',
            UserController::class
        );


        // Admin Staff Management
        Route::prefix('admin')
            ->name('admin.')
            ->group(function () {

                Route::resource(
                    'staff',
                    UserController::class
                );

            });


        // Reports
        Route::get(
            '/reports',
            [ReportController::class, 'index']
        )->name('reports.index');

    });


    // Cashier Routes
    Route::middleware('role:cashier')->group(function () {

        // Store Cashier Order
        Route::post(
            '/cashier/orders',
            [OrderController::class, 'cashierStore']
        )->name('cashier.orders.store');


        // Receipt
        Route::get(
            '/cashier/orders/{order}/receipt',
            [OrderController::class, 'receipt']
        )->name('cashier.orders.receipt');


        // Kitchen Order Ticket
        Route::get(
            '/cashier/orders/{order}/kot',
            [OrderController::class, 'kot']
        )->name('cashier.orders.kot');

    });


    // Chef Routes
    Route::middleware('role:chef')->group(function () {

        // Update Food Quantity
        Route::patch(
            '/chef/foods/{food}/quantity',
            [ChefController::class, 'updateQuantity']
        )->name('chef.foods.quantity');


        // Update Chef Order Status
        Route::patch(
            '/chef/orders/{order}/status',
            [ChefController::class, 'updateOrderStatus']
        )->name('chef.orders.status');


        // Chef Dashboard Data
        Route::get(
            '/chef/data',
            [ChefController::class, 'data']
        )->name('chef.data');

    });

});


// Customer Display
Route::get(
    '/customer-display',
    [CustomerDisplayController::class, 'index']
)->name('customer.display');


// Customer Display Data
Route::get(
    '/customer-display/data',
    [CustomerDisplayController::class, 'data']
)->name('customer.display.data');


// Queue Display
Route::get(
    '/queue-display',
    [QueueDisplayController::class, 'index']
)->name('queue.display');


// Queue Display Data
Route::get(
    '/queue-display/data',
    [QueueDisplayController::class, 'data']
)->name('queue.display.data');


// Language Change
Route::get(
    '/language/{lang}',
    function ($lang) {

        abort_unless(
            in_array(
                $lang,
                ['si', 'ta', 'en'],
                true
            ),
            404
        );

        session()->put(
            'locale',
            $lang
        );

        return back();

    }
)->name('language');


// Authentication Routes
require __DIR__ . '/auth.php';
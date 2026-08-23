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


// Public Pages

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/locations', function () {
    return view('locations');
})->name('public.locations');

Route::get('/about', function () {
    return view('about');
})->name('public.about');

Route::get('/contact', function () {
    return view('contact');
})->name('public.contact');

// Authenticated
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
    $user = auth()->user();

    return match ($user->role) {
        'admin', 'manager' => redirect()->route('admin.dashboard'),
        'cashier' => redirect()->route('cashier.dashboard'),
        'chef' => redirect()->route('chef.dashboard'),
        default => abort(403, 'Unauthorized access.'),
    };
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


    // Admin + Manager
    Route::middleware('role:admin,manager')->group(function () {

        // Outlets
        Route::resource(
            'outlets',
            OutletController::class
        );


        // Counters
        Route::resource(
            'counters',
            CounterController::class
        )->except([
            'show'
        ]);


        // Foods
        Route::resource(
            'foods',
            FoodController::class
        );


        // Categories
        Route::resource(
            'categories',
            CategoryController::class
        );


        // Payments
        Route::resource(
            'payments',
            PaymentController::class
        );


        // Kitchen Tickets
        Route::resource(
            'kitchen-tickets',
            KitchenTicketController::class
        );


        // Users
        Route::resource(
            'users',
            UserController::class
        );


        // Staff
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


    // Cashier
    Route::middleware('role:cashier')->group(function () {

        // Create Order
        Route::post(
            '/cashier/orders',
            [OrderController::class, 'cashierStore']
        )->name('cashier.orders.store');


        // Receipt
        Route::get(
            '/cashier/orders/{order}/receipt',
            [OrderController::class, 'receipt']
        )->name('cashier.orders.receipt');


        // KOT
        Route::get(
            '/cashier/orders/{order}/kot',
            [OrderController::class, 'kot']
        )->name('cashier.orders.kot');
    });


    // Chef
    Route::middleware('role:chef')->group(function () {

        // Food Quantity
        Route::patch(
            '/chef/foods/{food}/quantity',
            [ChefController::class, 'updateFoodQuantity']
        )->name('chef.foods.quantity');


        // Order Status
        Route::patch(
            '/chef/orders/{order}/status',
            [ChefController::class, 'updateOrderStatus']
        )->name('chef.orders.status');


        // Complete Order
        Route::post(
            '/chef/orders/{order}/complete',
            [ChefController::class, 'completeOrder']
        )->name('chef.orders.complete');


        // Chef Data
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

Route::get(
    '/customer-display/data',
    [CustomerDisplayController::class, 'data']
)->name('customer.display.data');


// Queue Display
Route::get(
    '/queue-display',
    [QueueDisplayController::class, 'index']
)->name('queue.display');

Route::get(
    '/queue-display/data',
    [QueueDisplayController::class, 'data']
)->name('queue.display.data');


// Language
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


// Authentication
require __DIR__ . '/auth.php';
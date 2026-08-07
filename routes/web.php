<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KitchenTicketController;
use App\Http\Controllers\QueueDisplayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerDisplayController;
use App\Http\Controllers\UserController;



// Home Page

Route::get('/', function () {

    return view('index');

});




// Admin Dashboard

Route::get('/admin-dashboard',
[DashboardController::class,'admin'])
->middleware('auth');




// Cashier Dashboard

Route::get('/cashier-dashboard',
[DashboardController::class,'cashier'])
->middleware('auth');




// Chef Dashboard

Route::get('/chef-dashboard',
[DashboardController::class,'chef'])
->middleware('auth');




// Default Dashboard

Route::get('/dashboard', function () {

    return view('dashboard');

})
->middleware(['auth'])
->name('dashboard');






// Authenticated Routes

Route::middleware('auth')->group(function () {



    Route::get('/profile', 
    [ProfileController::class, 'edit'])
    ->name('profile.edit');



    Route::patch('/profile', 
    [ProfileController::class, 'update'])
    ->name('profile.update');



    Route::delete('/profile', 
    [ProfileController::class, 'destroy'])
    ->name('profile.destroy');




    // Outlet Management

    Route::resource('outlets', OutletController::class);



    // Food Management

    Route::resource('foods', FoodController::class);



    // Category Management

    Route::resource('categories', CategoryController::class);



    // Order Management

    Route::resource('orders', OrderController::class);



    // Payment Management

    Route::resource('payments', PaymentController::class);



    // Kitchen Ticket

    Route::resource('kitchen-tickets', KitchenTicketController::class);




    // Queue Display

    Route::get('/queue-display',
    [QueueDisplayController::class,'index'])
    ->name('queue.display');



    // Customer Display

    Route::get('/customer-display',
    [CustomerDisplayController::class,'index'])
    ->name('customer.display');



    // Staff Management

    Route::resource('users', UserController::class);



});





// Language Change Route

Route::get('/language/{lang}', function($lang){

    session()->put('locale',$lang);

    return back();

});






require __DIR__.'/auth.php';
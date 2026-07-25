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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware(['auth', 'verified'])
->name('dashboard');



Route::middleware('auth')->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');


    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');



    Route::resource('outlets', OutletController::class);

    Route::resource('foods', FoodController::class);

    Route::resource('categories', CategoryController::class);

    Route::resource('orders', OrderController::class);

    Route::resource('payments', PaymentController::class);

    Route::resource('kitchen-tickets', KitchenTicketController::class);

    Route::resource('queue-displays', QueueDisplayController::class);


});


require __DIR__.'/auth.php';
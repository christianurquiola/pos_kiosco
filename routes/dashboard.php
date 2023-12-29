<?php

use App\Http\Controllers\Dashboard\Client\OrderController;
use App\Http\Controllers\Dashboard\OrderController as orderSelfController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::fallback(fn()=> to_route('dashboard.welcome'));
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale().'/dashboard',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ,'auth' ]
    ], function(){ //...

    Route::get('/', [DashboardController::class,'index'])->name('welcome');
    Route::resource('users',UserController::class)->except('show');
    Route::resource('categories',CategoryController::class)->except('show');
    Route::resource('products',ProductController::class)->except('show');
    Route::resource('clients.orders',OrderController::class)->except(['show','index','destroy']);
    Route::resource('clients',ClientController::class)->except('show');

    Route::resource('orders',orderSelfController::class)->only(['index','destroy']);
    Route::get('orders/{order}/products',[orderSelfController::class , 'showProduct'])->name('orders.products');

    require __DIR__.'/auth.php';

});





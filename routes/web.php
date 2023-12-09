<?php

use App\Http\Controllers\DishesController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });



Auth::routes();


Route::resource('/dish', App\Http\Controllers\DishesController::class);
Route::get('/order',[DishesController::class, 'order'])->name('order.kitchen');

//make order and submit order
Route::get('/',[OrderController::class,'index'])->name('order.form');
Route::post('/submit',[OrderController::class,'submit'])->name('order.submit');
Route::get('order/{order}/serve', [App\Http\Controllers\OrderController::class, 'serve']);

//order panel route

Route::get('order/{order}/approve',[App\Http\Controllers\DishesController::class, 'approve']);
Route::get('order/{order}/cancel', [App\Http\Controllers\DishesController::class, 'cancel']);
Route::get('order/{order}/ready', [App\Http\Controllers\DishesController::class, 'ready']);


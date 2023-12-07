<?php

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

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();


Route::resource('/dish', App\Http\Controllers\DishesController::class);
Route::get('/order',[OrderController::class,'index'])->name('order.form');
Route::post('/submit',[OrderController::class,'submit'])->name('order.submit');

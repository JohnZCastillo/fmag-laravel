<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [HomeController::class,'index']);
Route::get('/shop', [ShopController::class,'index']);
Route::get('/cart', [CartController::class,'index']);

Route::delete('/cart-item/{item}', [CartItemController::class,'removeItem']);

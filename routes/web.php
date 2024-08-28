<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [HomeController::class,'index']);
Route::get('/shop', [ShopController::class,'index']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;


Route::get('/', [MenuController::class, 'home']);


Route::get('/products', [ProductController::class, 'products'])->name('products');


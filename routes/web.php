<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'home']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', [ProductController::class, 'products'])->name('products');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::middleware('auth')->group(function () {

    // ⭐ Your custom profile page
    Route::get('/my-profile', [UserController::class, 'profile'])->name('user.profile');

    // ⭐ Your custom update routes
    Route::post('/my-profile/update-name', [UserController::class, 'updateName'])->name('user.updateName');
    Route::post('/my-profile/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::delete('/my-profile/delete', [UserController::class, 'destroy'])->name('user.destroy');

    // ⭐ Keranjang (Cart) routes
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/keranjang/{keranjang}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{keranjang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

    // ⭐ Admin routes - Product Management
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', AdminProductController::class);
    });
});


require __DIR__.'/auth.php';

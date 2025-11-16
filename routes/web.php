<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AdminOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'home']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', [ProductController::class, 'products'])->name('products');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/review', [\App\Http\Controllers\ReviewController::class, 'index'])->name('review');
Route::post('/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store')->middleware('auth');
Route::put('/review/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('review.update')->middleware('auth');
Route::delete('/review/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('review.destroy')->middleware('auth');

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

    // ⭐ Order routes (User)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/dine-in', [OrderController::class, 'dineIn'])->name('orders.dineIn');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // ⭐ Payment routes
    Route::post('/orders/{order}/payment', [\App\Http\Controllers\PaymentController::class, 'storeOrder'])->name('payment.order');
    Route::post('/keranjang/payment', [\App\Http\Controllers\PaymentController::class, 'storeCart'])->name('payment.cart');

    // ⭐ Promo routes
    Route::post('/promo/apply', [\App\Http\Controllers\PromoController::class, 'apply'])->name('promo.apply');

    // ⭐ Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', AdminProductController::class);
        Route::put('products/{id}/stock', [AdminProductController::class, 'updateStock'])->name('products.updateStock');
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::get('deliveries', [\App\Http\Controllers\Admin\AdminDeliveriesController::class, 'index'])->name('deliveries.index');
        Route::resource('promos', \App\Http\Controllers\PromoController::class);
    });
});


require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\AdminProductController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Route
Route::middleware('auth', 'admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::patch('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');

});

// Products Route
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

// Cart Route
Route::get('/cart', [CartController::class, 'show'])->middleware('auth')->name('cart.show');
Route::post('/cart/items', [CartItemController::class, 'store'])->middleware('auth');
Route::delete('/cart/items/{cartItem}', [CartItemController::class, 'destroy'])->middleware('auth')->name('cart.items.destroy');
Route::patch('/cart/items/{cartItem}', [CartItemController::class, 'update'])->middleware('auth')->name('cart.items.update');

require __DIR__.'/auth.php';

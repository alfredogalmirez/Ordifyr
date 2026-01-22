<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Products Route
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

// Cart Route
Route::get('/cart', [CartController::class, 'show'])->middleware('auth')->name('cart.show');
Route::post('/cart/items', [CartItemController::class, 'store'])->middleware('auth');
Route::delete('/cart/items/{cartItem}', [CartItemController::class, 'destroy'])->middleware('auth')->name('cart.items.destroy');

require __DIR__.'/auth.php';

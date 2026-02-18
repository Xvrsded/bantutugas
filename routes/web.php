<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminOrderController;

// Public Routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/how-to-order', [PageController::class, 'howToOrder'])->name('how-to-order');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');

// Order Routes
Route::get('/order/create/{service}', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');

// Checkout Routes
Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [OrderController::class, 'processCheckout'])->name('checkout.process');

// Admin Routes
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Orders Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
});

// Authentication Routes
require __DIR__.'/auth.php';

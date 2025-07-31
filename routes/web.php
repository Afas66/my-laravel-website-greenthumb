<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;
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

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/plants', [PlantController::class, 'index'])->name('plants.index');
Route::get('/plants/{plant:slug}', [PlantController::class, 'show'])->name('plants.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Cart Routes (accessible to guests and authenticated users)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{plant}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{cartItem}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Dashboard (redirect based on role)
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->isStaff()) {
        return redirect()->route('staff.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Plant Management
    Route::resource('plants', \App\Http\Controllers\Admin\PlantController::class);
    Route::patch('plants/{plant}/toggle-featured', [\App\Http\Controllers\Admin\PlantController::class, 'toggleFeatured'])->name('plants.toggle-featured');
    Route::patch('plants/{plant}/toggle-active', [\App\Http\Controllers\Admin\PlantController::class, 'toggleActive'])->name('plants.toggle-active');

    // Category Management
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::patch('categories/{category}/toggle-active', [\App\Http\Controllers\Admin\CategoryController::class, 'toggleActive'])->name('categories.toggle-active');

    // Order Management
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'destroy']);
    Route::patch('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('orders/{order}/cancel', [\App\Http\Controllers\Admin\OrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('orders/bulk-update-status', [\App\Http\Controllers\Admin\OrderController::class, 'bulkUpdateStatus'])->name('orders.bulk-update-status');

    // User Management (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::patch('users/{user}/toggle-verification', [\App\Http\Controllers\Admin\UserController::class, 'toggleVerification'])->name('users.toggle-verification');
        Route::delete('users/bulk-delete', [\App\Http\Controllers\Admin\UserController::class, 'bulkDelete'])->name('users.bulk-delete');
    });
});

// Staff Routes (additional staff-specific functionality)
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/', [StaffDashboardController::class, 'index'])->name('dashboard');
    Route::patch('orders/{order}/quick-status', [StaffDashboardController::class, 'quickUpdateOrderStatus'])->name('orders.quick-status');
    Route::patch('orders/mark-processing', [StaffDashboardController::class, 'markAsProcessing'])->name('orders.mark-processing');
    Route::patch('plants/{plant}/update-stock', [StaffDashboardController::class, 'updateStock'])->name('plants.update-stock');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

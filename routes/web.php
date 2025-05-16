<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

# Dashboard page
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

# List of inventory in Inventory page
Route::get('/inventory', [InventoryController::class, 'index'])->middleware(['auth', 'verified'])->name('inventory');

# Form for inventory
Route::get('/itemForm', [InventoryController::class, 'create'])->middleware(['auth', 'verified'])->name('itemForm');
Route::post('/itemForm', [InventoryController::class, 'store'])->middleware(['auth', 'verified'])->name('itemForm.store');

Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->middleware(['auth', 'verified'])->name('inventories.edit');
Route::put('/inventory/{id}', [InventoryController::class, 'update'])->middleware(['auth', 'verified'])->name('inventories.update');

# User list page
Route::get('/user', function () {
    return view('user');
})->middleware(['auth', 'verified'])->name('user');

#Route::get('/user', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('user');
Route::get('/user', [UserController::class, 'index'])->name('user');

# Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

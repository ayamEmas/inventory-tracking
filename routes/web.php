<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

# Dashboard page
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

# Inventory
Route::get('/inventory', function () {
    return view('inventory');
})->middleware(['auth', 'verified'])->name('inventory');

# Form for inventory
Route::get('/itemForm', function () {
    return view('itemForm');
})->middleware(['auth', 'verified'])->name('itemForm');

Route::get('/itemForm', [InventoryController::class, 'index'])->name('itemForm');
Route::post('/itemForm', [InventoryController::class, 'store'])->name('itemForm.store');

# Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

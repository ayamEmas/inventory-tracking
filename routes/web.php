<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisposalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/welcome');
});

# Dashboard page
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

# List of inventory in Inventory page
Route::get('/inventory', [InventoryController::class, 'index'])->middleware(['auth', 'verified'])->name('inventory');

# Form for inventory
Route::get('/itemForm', [InventoryController::class, 'create'])->middleware(['auth', 'verified'])->name('itemForm');
Route::post('/itemForm', [InventoryController::class, 'store'])->middleware(['auth', 'verified'])->name('itemForm.store');

Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->middleware(['auth', 'verified'])->name('inventories.edit');
Route::put('/inventory/{id}', [InventoryController::class, 'update'])->middleware(['auth', 'verified'])->name('inventories.update');

Route::get('/inventories/{id}/download-qr', [InventoryController::class, 'downloadQr'])->name('inventories.download-qr');
Route::get('/inventories/download-pdf', [InventoryController::class, 'downloadPdf'])->name('inventories.download-pdf');
Route::get('/inventories/{id}/download-pdf', [InventoryController::class, 'downloadSinglePdf'])->name('inventories.download-single-pdf');
Route::get('/inventories/deleted/{id}/download-pdf', [InventoryController::class, 'downloadDeletedPdf'])->name('inventories.download-deleted-pdf');
Route::get('/inventories/deleted', [InventoryController::class, 'deletedItems'])->name('inventories.deleted');
Route::post('/inventories/{id}/restore', [InventoryController::class, 'restore'])->name('inventories.restore');

# User list page
Route::get('/user', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('user');

# User form page and add function
Route::get('/userForm', [UserController::class, 'create'])->middleware(['auth', 'verified'])->name('userForm');
Route::post('/userForm', [UserController::class, 'store'])->middleware(['auth', 'verified'])->name('userForm.store');

# Update user page and edit function
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->middleware(['auth', 'verified'])->name('users.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('users.update');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->middleware(['auth', 'verified'])->name('users.destroy');

Route::post('/users/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
Route::post('/stop-impersonating', [UserController::class, 'stopImpersonating'])->name('stop.impersonating');

# Disposal page
Route::get('/pelupusan', [DisposalController::class, 'index'])->middleware(['auth', 'verified'])->name('pelupusan');
Route::match(['get', 'post'], '/pelupusan/search', [DisposalController::class, 'search'])->middleware(['auth', 'verified'])->name('pelupusan.search');
Route::post('/pelupusan/store', [DisposalController::class, 'store'])->middleware(['auth', 'verified'])->name('pelupusan.store');

# Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
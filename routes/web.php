<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route សម្រាប់ User ធម្មតា
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route សម្រាប់ Admin (យើងទើបបន្ថែមថ្មីនៅត្រង់នេះ)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ប្រអប់ Route សម្រាប់តែ Admin ប៉ុណ្ណោះ
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    
    // ទំព័រ Admin Dashboard ដើម
    Route::get('/dashboard', function () {
        // បើមានលក្ខខណ្ឌឆែក role 'admin' ក្នុង Middleware កាន់តែល្អ
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Routes សម្រាប់គ្រប់គ្រងប្រភេទ និងកុំព្យូទ័រ
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    
});

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('shop.show');

Route::post('/product/{product}/review', [App\Http\Controllers\ShopController::class, 'storeReview'])->name('reviews.store');


Route::resource('categories', \App\Http\Controllers\CategoryController::class);
require __DIR__.'/auth.php';
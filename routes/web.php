<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// ហាងលក់ទំនិញ និងទំព័រលម្អិត
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::redirect('/home', '/')->name('home');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('shop.show');
Route::post('/product/{product}/review', [ShopController::class, 'storeReview'])->name('reviews.store');

Route::middleware('auth')->group(function () {
    // User Dashboard ធម្មតា
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // ការកំណត់ Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (សម្រាប់គ្រប់គ្រងហាង)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {

    // Dashboard របស់ Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // ការគ្រប់គ្រងទិន្នន័យ (រៀបចំកូដឱ្យខ្លីដោយប្រើ Alias ពីខាងលើ)
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);

});

// ដំណើរការប្រព័ន្ធចុះឈ្មោះ និង Login
require __DIR__.'/auth.php';

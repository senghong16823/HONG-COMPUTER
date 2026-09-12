<?php

use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PosController as AdminPosController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// 1. ហាងលក់ទំនិញ និងទំព័រលម្អិត (Storefront & Products)
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::redirect('/home', '/')->name('home');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('shop.show');
Route::post('/product/{product}/review', [ShopController::class, 'storeReview'])->name('reviews.store');

// 2. កន្ត្រកទំនិញ (Shopping Cart)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::get('/cart/mini', [CartController::class, 'miniCart'])->name('cart.mini');

// 3. ទូទាត់ប្រាក់ & បញ្ជាក់ការបញ្ជាទិញ (Checkout & Confirmation)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/{order_number}/confirmation', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

// 4. តាមដានការបញ្ជាទិញជាសាធារណៈ (Public Order Tracking)
Route::get('/order-tracking', [CustomerOrderController::class, 'track'])->name('order.track');

Route::middleware('auth')->group(function () {
    // 5. បញ្ជីការបញ្ជាទិញរបស់ខ្ញុំ (Customer My Orders)
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('customer.orders');

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
| Admin Panel Routes (សម្រាប់គ្រប់គ្រងហាងតាម Menu)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {

    // 1. Dashboard ទិដ្ឋភាពទូទៅ
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // 2. POS លក់រាយ
    Route::get('/pos', [AdminPosController::class, 'index'])->name('admin.pos.index');
    Route::post('/pos/checkout', [AdminPosController::class, 'checkout'])->name('admin.pos.checkout');

    // 3. Orders ការបញ្ជាទិញ
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

    // 4. Products, Categories, Brands គ្រប់គ្រងទំនិញ
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);
    Route::resource('brands', AdminBrandController::class);

    // 5. Customers អតិថិជន
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/customers/{customer}', [AdminCustomerController::class, 'show'])->name('admin.customers.show');

    // 6. Coupons / Promotions ប្រូម៉ូសិន & គូប៉ុង
    Route::resource('coupons', AdminCouponController::class, ['as' => 'admin']);

    // 7. Reports របាយការណ៍
    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');

    // 8. Settings ការកំណត់
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');

});

// ដំណើរការប្រព័ន្ធចុះឈ្មោះ និង Login
require __DIR__.'/auth.php';

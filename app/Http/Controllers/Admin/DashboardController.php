<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Stats
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $processingOrders = Order::whereIn('status', ['pending', 'processing'])->count();
        $totalCustomers = User::where('is_admin', false)->count();
        $lowStockCount = Product::where('stock', '<=', 5)->count();

        // 2. Recent Orders
        $recentOrders = Order::with('items')
            ->latest()
            ->take(5)
            ->get();

        // 3. Top Selling Products
        $topProducts = Product::select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as sold_count'), DB::raw('COALESCE(SUM(order_items.total), 0) as total_earned'))
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('sold_count')
            ->take(4)
            ->get();

        // 4. Low stock products
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'processingOrders',
            'totalCustomers',
            'lowStockCount',
            'recentOrders',
            'topProducts',
            'lowStockProducts'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->get('range', 'this_month');

        $query = Order::query();

        switch ($range) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'yesterday':
                $query->whereDate('created_at', today()->subDay());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;
            case 'this_year':
                $query->whereYear('created_at', now()->year);
                break;
            case 'all':
            default:
                break;
        }

        $orders = $query->get();

        $totalRevenue = $orders->where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = $orders->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $totalDiscount = $orders->sum('discount_amount');

        // Sales by payment method
        $paymentMethods = [
            'cash' => $orders->where('payment_method', 'cash')->where('payment_status', 'paid')->sum('total_amount'),
            'aba_khqr' => $orders->where('payment_method', 'aba_khqr')->where('payment_status', 'paid')->sum('total_amount'),
            'card' => $orders->where('payment_method', 'card')->where('payment_status', 'paid')->sum('total_amount'),
        ];

        // Sales by source
        $sources = [
            'pos' => $orders->where('source', 'pos')->where('payment_status', 'paid')->sum('total_amount'),
            'web' => $orders->where('source', 'web')->where('payment_status', 'paid')->sum('total_amount'),
        ];

        // Top Selling Products in period
        $orderIds = $orders->pluck('id');
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as units_sold'), DB::raw('SUM(total) as revenue'))
            ->whereIn('order_id', $orderIds)
            ->groupBy('product_name')
            ->orderByDesc('units_sold')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'range',
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'avgOrderValue',
            'totalDiscount',
            'paymentMethods',
            'sources',
            'topProducts'
        ));
    }
}

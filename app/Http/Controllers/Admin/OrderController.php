<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $query = Order::with('items')->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        // Status counts
        $counts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'counts', 'status', 'search'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'nullable|in:paid,unpaid,refunded',
            'notes' => 'nullable|string',
        ]);

        $order->update(array_filter($validated, fn ($val) => ! is_null($val)));

        return back()->with('success', "ស្ថានភាពការបញ្ជាទិញ #{$order->order_number} ត្រូវបានកែប្រែដោយជោគជ័យ!");
    }

    public function destroy(Order $order)
    {
        $orderNumber = $order->order_number;
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', "ការបញ្ជាទិញ #{$orderNumber} ត្រូវបានលុបជោគជ័យ!");
    }
}

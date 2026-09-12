<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with(['category', 'brand'])
            ->latest()
            ->get();

        $coupons = Coupon::where('is_active', true)->get();
        $taxRate = (float) Setting::get('tax_rate', 0);
        $currencySymbol = Setting::get('currency_symbol', '$');

        return view('admin.pos.index', compact('categories', 'products', 'coupons', 'taxRate', 'currencySymbol'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'payment_method' => 'required|string|in:cash,aba_khqr,card',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.name' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {
            $orderNumber = Order::generateOrderNumber();

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => null,
                'customer_name' => $validated['customer_name'] ?? 'Walk-in Customer (អតិថិជនទូទៅ)',
                'customer_phone' => $validated['customer_phone'] ?? null,
                'customer_email' => null,
                'shipping_address' => 'ទិញផ្ទាល់នៅហាង (POS Storefront)',
                'subtotal' => $validated['subtotal'],
                'discount_amount' => $validated['discount_amount'] ?? 0,
                'tax_amount' => $validated['tax_amount'] ?? 0,
                'total_amount' => $validated['total_amount'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'paid',
                'status' => 'completed',
                'source' => 'pos',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);

                // Decrement stock
                Product::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
            }

            return response()->json([
                'success' => true,
                'message' => 'ការលក់ជោគជ័យ! (Sale Completed)',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => number_format($order->total_amount, 2),
                'date' => $order->created_at->format('d/m/Y H:i A'),
            ]);
        });
    }
}

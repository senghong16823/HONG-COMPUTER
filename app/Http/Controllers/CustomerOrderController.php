<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    /**
     * បញ្ជីការបញ្ជាទិញរបស់អតិថិជន (Customer "My Orders" Dashboard)
     */
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $currencySymbol = Setting::get('currency_symbol', '$');

        return view('shop.my-orders', compact('orders', 'currencySymbol'));
    }

    /**
     * តាមដានស្ថានភាពការបញ្ជាទិញជាសាធារណៈ (Public Order Tracking)
     */
    public function track(Request $request)
    {
        $orderNumber = trim($request->get('order_number', ''));
        $phone = trim($request->get('phone', ''));

        $order = null;
        $searched = false;

        if ($orderNumber && $phone) {
            $searched = true;
            $order = Order::with('items.product')
                ->where('order_number', $orderNumber)
                ->where(function ($q) use ($phone) {
                    $q->where('customer_phone', $phone)
                        ->orWhere('customer_phone', 'like', "%{$phone}%");
                })
                ->first();
        }

        $currencySymbol = Setting::get('currency_symbol', '$');

        return view('shop.track', compact('order', 'orderNumber', 'phone', 'searched', 'currencySymbol'));
    }
}

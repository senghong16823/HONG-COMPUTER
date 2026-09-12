<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * បង្ហាញទំព័រទូទាត់ប្រាក់ (Checkout Form Page)
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'កន្ត្រកទំនិញរបស់អ្នកនៅទទេឡើយ!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = session()->get('coupon');
        $discountAmount = $coupon['discount'] ?? 0;

        $shippingFee = (float) Setting::get('shipping_fee', 2.00);
        $taxRate = (float) Setting::get('tax_rate', 0);
        $taxAmount = ($subtotal - $discountAmount) * ($taxRate / 100);
        $total = max(0, $subtotal - $discountAmount + $shippingFee + $taxAmount);

        $currencySymbol = Setting::get('currency_symbol', '$');
        $currentUser = auth()->user();

        return view('shop.checkout', compact(
            'cart',
            'coupon',
            'subtotal',
            'discountAmount',
            'shippingFee',
            'taxRate',
            'taxAmount',
            'total',
            'currencySymbol',
            'currentUser'
        ));
    }

    /**
     * ដំណើរការបង្កើតការបញ្ជាទិញ (Process & Place Order)
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'កន្ត្រកទំនិញរបស់អ្នកនៅទទេឡើយ!');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_email' => 'nullable|email|max:255',
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,aba_khqr,card',
            'notes' => 'nullable|string|max:1000',
        ]);

        return DB::transaction(function () use ($validated, $cart) {
            // 1. ត្រួតពិនិត្យស្តុកទំនិញជាក់ស្តែងទាំងអស់ក្នុង Database
            $subtotal = 0;
            foreach ($cart as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);
                if (! $product || $product->stock < $item['quantity']) {
                    return back()->with('error', "ទំនិញ \"{$item['name']}\" មិនមានស្តុកគ្រប់គ្រាន់សម្រាប់ចំនួនបញ្ជាទិញនេះទេ!");
                }
                $subtotal += $item['price'] * $item['quantity'];
            }

            // 2. គណនាការបញ្ចុះតម្លៃពីគូប៉ុង
            $coupon = session()->get('coupon');
            $discountAmount = 0;
            $dbCoupon = null;

            if ($coupon) {
                $dbCoupon = Coupon::where('code', $coupon['code'])->first();
                if ($dbCoupon && $dbCoupon->isValid($subtotal)) {
                    $discountAmount = $dbCoupon->calculateDiscount($subtotal);
                }
            }

            $shippingFee = (float) Setting::get('shipping_fee', 2.00);
            $taxRate = (float) Setting::get('tax_rate', 0);
            $taxAmount = ($subtotal - $discountAmount) * ($taxRate / 100);
            $totalAmount = max(0, $subtotal - $discountAmount + $shippingFee + $taxAmount);

            // 3. បង្កើត Order Record
            $orderNumber = Order::generateOrderNumber();
            $paymentMethodMap = [
                'cod' => 'cash',
                'aba_khqr' => 'aba_khqr',
                'card' => 'card',
            ];

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id() ?? null,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'] ?? (auth()->user()?->email),
                'shipping_address' => $validated['shipping_address'],
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethodMap[$validated['payment_method']] ?? 'cash',
                'payment_status' => $validated['payment_method'] === 'aba_khqr' ? 'paid' : 'unpaid',
                'status' => 'pending',
                'source' => 'online',
                'notes' => $validated['notes'] ?? null,
            ]);

            // 4. បង្កើត OrderItems និងកាត់ស្តុកទំនិញ
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);

                // កាត់ស្តុកកុំព្យូទ័រ
                Product::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
            }

            // 5. បូកចំនួនដងដែលបានប្រើគូប៉ុង
            if ($dbCoupon && $discountAmount > 0) {
                $dbCoupon->increment('used_count');
            }

            // 6. សម្អាត Session Cart & Coupon
            session()->forget(['cart', 'coupon']);

            // 7. បញ្ជូនទៅកាន់ទំព័រជោគជ័យ
            return redirect()->route('order.confirmation', $order->order_number)
                ->with('success', "ការបញ្ជាទិញ #{$order->order_number} ទទួលបានជោគជ័យ!");
        });
    }

    /**
     * ទំព័របញ្ជាក់ការបញ្ជាទិញជោគជ័យ (Order Confirmation & Tracking Timeline)
     */
    public function confirmation(string $orderNumber)
    {
        $order = Order::with(['items.product', 'user'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        $currencySymbol = Setting::get('currency_symbol', '$');
        $storePhone = Setting::get('store_phone', '093 757 079');
        $telegramNumber = Setting::get('telegram_number', '093 757 079');

        return view('shop.confirmation', compact('order', 'currencySymbol', 'storePhone', 'telegramNumber'));
    }
}

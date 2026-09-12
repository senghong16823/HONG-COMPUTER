<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * បង្ហាញទំព័រកន្ត្រកទំនិញ (Shopping Cart Page)
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $coupon = session()->get('coupon');

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discountAmount = 0;
        if ($coupon) {
            $dbCoupon = Coupon::where('code', $coupon['code'])->first();
            if ($dbCoupon && $dbCoupon->isValid($subtotal)) {
                $discountAmount = $dbCoupon->calculateDiscount($subtotal);
                // Update session coupon discount
                $coupon['discount'] = $discountAmount;
                session()->put('coupon', $coupon);
            } else {
                session()->forget('coupon');
                $coupon = null;
            }
        }

        $shippingFee = (float) Setting::get('shipping_fee', 2.00);
        $taxRate = (float) Setting::get('tax_rate', 0); // e.g. 0%
        $taxAmount = ($subtotal - $discountAmount) * ($taxRate / 100);
        $total = max(0, $subtotal - $discountAmount + $shippingFee + $taxAmount);

        $currencySymbol = Setting::get('currency_symbol', '$');

        return view('shop.cart', compact(
            'cart',
            'coupon',
            'subtotal',
            'discountAmount',
            'shippingFee',
            'taxRate',
            'taxAmount',
            'total',
            'currencySymbol'
        ));
    }

    /**
     * បន្ថែមទំនិញចូលកន្ត្រក (Add item to cart)
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::with(['category', 'brand'])->findOrFail($request->product_id);
        $quantity = (int) $request->input('quantity', 1);

        if ($product->stock < 1) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ទំនិញនេះអស់ពីស្តុកហើយ!',
                ], 422);
            }

            return back()->with('error', 'ទំនិញនេះអស់ពីស្តុកហើយ!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            if ($newQuantity > $product->stock) {
                $newQuantity = $product->stock;
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
                'category' => $product->category->name ?? 'Computer',
                'brand' => $product->brand->name ?? null,
                'quantity' => min($quantity, $product->stock),
                'max_stock' => $product->stock,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "បានបន្ថែម \"{$product->name}\" ចូលកន្ត្រក!",
                'cart_count' => $cartCount,
                'cart' => $cart,
            ]);
        }

        return back()->with('success', "បានបន្ថែម \"{$product->name}\" ចូលកន្ត្រកជោគជ័យ!");
    }

    /**
     * កែប្រែចំនួនទំនិញក្នុងកន្ត្រក (Update quantity)
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($quantity > $product->stock) {
                $quantity = $product->stock;
            }
            $cart[$product->id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'បានកែប្រែចំនួនទំនិញជោគជ័យ!',
                'cart_count' => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'បានកែប្រែចំនួនទំនិញជោគជ័យ!');
    }

    /**
     * លុបទំនិញមួយចេញពីកន្ត្រក (Remove item)
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $name = $cart[$productId]['name'];
            unset($cart[$productId]);
            session()->put('cart', $cart);

            if (empty($cart)) {
                session()->forget('coupon');
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "បានលុប \"{$name}\" ចេញពីកន្ត្រក!",
                    'cart_count' => array_sum(array_column($cart, 'quantity')),
                ]);
            }

            return redirect()->route('cart.index')->with('success', "បានលុប \"{$name}\" ចេញពីកន្ត្រក!");
        }

        return redirect()->route('cart.index');
    }

    /**
     * សម្អាតកន្ត្រកទំនិញទាំងអស់ (Clear entire cart)
     */
    public function clear()
    {
        session()->forget(['cart', 'coupon']);

        return redirect()->route('cart.index')->with('success', 'បានសម្អាតកន្ត្រកទំនិញទាំងមូល!');
    }

    /**
     * ប្រើប្រាស់កូដគូប៉ុងបញ្ចុះតម្លៃ (Apply coupon)
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $code = strtoupper(trim($request->code));
        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon) {
            return back()->with('error', 'លេខកូដគូប៉ុងនេះមិនត្រឹមត្រូវឡើយ!');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'សូមបញ្ចូលទំនិញក្នុងកន្ត្រកមុននឹងប្រើប្រាស់គូប៉ុង!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if (! $coupon->isValid($subtotal)) {
            $message = 'គូប៉ុងនេះមិនអាចប្រើប្រាស់បានទេ';
            if (! $coupon->is_active) {
                $message .= ' (គូប៉ុងត្រូវបានបិទ)';
            } elseif ($coupon->end_date && now()->startOfDay()->gt($coupon->end_date)) {
                $message .= ' (គូប៉ុងបានផុតកំណត់)';
            } elseif ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
                $message .= " (តម្រូវឱ្យទិញយ៉ាងតិច \${$coupon->min_order_amount})";
            } elseif ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
                $message .= ' (ចំនួនកំណត់នៃការប្រើប្រាស់បានអស់)';
            }

            return back()->with('error', $message);
        }

        $discount = $coupon->calculateDiscount($subtotal);

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => (float) $coupon->value,
            'discount' => (float) $discount,
        ]);

        return back()->with('success', "បានប្រើប្រាស់គូប៉ុង \"{$coupon->code}\" បញ្ចុះតម្លៃ \${$discount} ជោគជ័យ!");
    }

    /**
     * ដកគូប៉ុងចេញវិញ (Remove coupon)
     */
    public function removeCoupon()
    {
        session()->forget('coupon');

        return back()->with('success', 'បានដកគូប៉ុងចេញរួចរាល់!');
    }

    /**
     * ព័ត៌មានកន្ត្រកទំនិញសង្ខេបសម្រាប់ Header Mini-Cart (JSON)
     */
    public function miniCart()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'count' => $count,
            'subtotal' => $subtotal,
            'items' => array_values($cart),
        ]);
    }
}

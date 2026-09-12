<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FullProjectMenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Brands
        $brands = [
            [
                'name' => 'ASUS',
                'slug' => 'asus',
                'logo' => null,
                'website' => 'https://www.asus.com',
                'description' => 'ASUS Republic of Gamers (ROG) និង ZenBook កម្រិតខ្ពស់',
                'is_active' => true,
            ],
            [
                'name' => 'Lenovo',
                'slug' => 'lenovo',
                'logo' => null,
                'website' => 'https://www.lenovo.com',
                'description' => 'Lenovo ThinkPad និង Legion Gaming គុណភាពខ្ពស់',
                'is_active' => true,
            ],
            [
                'name' => 'Dell',
                'slug' => 'dell',
                'logo' => null,
                'website' => 'https://www.dell.com',
                'description' => 'Dell XPS, Alienware និង Latitude ធន់រឹងមាំ',
                'is_active' => true,
            ],
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'logo' => null,
                'website' => 'https://www.apple.com',
                'description' => 'MacBook Pro, MacBook Air, iMac និង Mac Studio',
                'is_active' => true,
            ],
            [
                'name' => 'MSI',
                'slug' => 'msi',
                'logo' => null,
                'website' => 'https://www.msi.com',
                'description' => 'MSI Gaming Laptops និង PC Components ឈានមុខគេ',
                'is_active' => true,
            ],
            [
                'name' => 'HP',
                'slug' => 'hp',
                'logo' => null,
                'website' => 'https://www.hp.com',
                'description' => 'HP Omen, Pavilion, Spectre និង Envy',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $b) {
            Brand::firstOrCreate(['slug' => $b['slug']], $b);
        }

        // Link existing products to brands if not set
        $asusBrand = Brand::where('slug', 'asus')->first();
        $lenovoBrand = Brand::where('slug', 'lenovo')->first();
        $dellBrand = Brand::where('slug', 'dell')->first();

        Product::where('name', 'like', '%Dell%')->update(['brand_id' => $dellBrand?->id]);
        Product::where('name', 'like', '%Lenovo%')->update(['brand_id' => $lenovoBrand?->id]);
        Product::where('name', 'like', '%Asus%')->update(['brand_id' => $asusBrand?->id]);

        // 2. Coupons
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percent',
                'value' => 10,
                'min_order_amount' => 50,
                'max_discount_amount' => 100,
                'is_active' => true,
            ],
            [
                'code' => 'DISCOUNT20',
                'type' => 'fixed',
                'value' => 20,
                'min_order_amount' => 100,
                'max_discount_amount' => 20,
                'is_active' => true,
            ],
            [
                'code' => 'GAMING50',
                'type' => 'fixed',
                'value' => 50,
                'min_order_amount' => 500,
                'max_discount_amount' => 50,
                'is_active' => true,
            ],
            [
                'code' => 'SUPERDEAL',
                'type' => 'percent',
                'value' => 15,
                'min_order_amount' => 200,
                'max_discount_amount' => 150,
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $c) {
            Coupon::firstOrCreate(['code' => $c['code']], $c);
        }

        // 3. Settings
        $settings = [
            'store_name' => 'HONG COMPUTER',
            'store_email' => 'contact@hongcomputer.com',
            'store_phone' => '093 757 079 / 012 345 678',
            'store_address' => 'ផ្លូវ 271, រាជធានីភ្នំពេញ, ប្រទេសកម្ពុជា',
            'currency_symbol' => '$',
            'tax_rate' => '0',
            'shipping_fee' => '2.00',
            'facebook_page' => 'https://facebook.com/hongcomputer',
            'telegram_number' => '093 757 079',
        ];

        foreach ($settings as $key => $val) {
            Setting::firstOrCreate(['key' => $key], ['value' => $val]);
        }

        // 4. Sample Orders & Order Items
        $products = Product::all();
        $users = User::all();
        $sampleUser = $users->firstWhere('is_admin', false) ?? $users->first();

        if ($products->count() > 0 && Order::count() === 0) {
            $sampleOrders = [
                [
                    'order_number' => 'ORD-8842',
                    'user_id' => $sampleUser?->id,
                    'customer_name' => 'Vireak Roth',
                    'customer_phone' => '012 888 999',
                    'customer_email' => 'vireak@example.com',
                    'shipping_address' => 'Tuol Kork, Phnom Penh',
                    'subtotal' => 2665.00,
                    'discount_amount' => 50.00,
                    'tax_amount' => 0.00,
                    'total_amount' => 2615.00,
                    'payment_method' => 'aba_khqr',
                    'payment_status' => 'paid',
                    'status' => 'completed',
                    'source' => 'web',
                    'notes' => 'ដឹកជញ្ជូនរហ័ស',
                    'created_at' => now()->subHours(3),
                ],
                [
                    'order_number' => 'ORD-8845',
                    'user_id' => null,
                    'customer_name' => 'Sok Heng',
                    'customer_phone' => '098 777 666',
                    'customer_email' => 'sokheng@example.com',
                    'shipping_address' => 'BKK1, Phnom Penh',
                    'subtotal' => 727.00,
                    'discount_amount' => 0.00,
                    'tax_amount' => 0.00,
                    'total_amount' => 727.00,
                    'payment_method' => 'cash',
                    'payment_status' => 'paid',
                    'status' => 'completed',
                    'source' => 'pos',
                    'notes' => 'ទិញនៅហាងផ្ទាល់ (POS)',
                    'created_at' => now()->subHours(6),
                ],
                [
                    'order_number' => 'ORD-8849',
                    'user_id' => $sampleUser?->id,
                    'customer_name' => 'Keo Pich',
                    'customer_phone' => '077 555 444',
                    'customer_email' => 'keopich@example.com',
                    'shipping_address' => 'Sen Sok, Phnom Penh',
                    'subtotal' => 1189.00,
                    'discount_amount' => 20.00,
                    'tax_amount' => 0.00,
                    'total_amount' => 1169.00,
                    'payment_method' => 'aba_khqr',
                    'payment_status' => 'paid',
                    'status' => 'processing',
                    'source' => 'web',
                    'notes' => 'រៀបចំកញ្ចប់ដឹក',
                    'created_at' => now()->subDay(),
                ],
                [
                    'order_number' => 'ORD-8850',
                    'user_id' => null,
                    'customer_name' => 'Chan Dara',
                    'customer_phone' => '015 222 333',
                    'customer_email' => 'dara@example.com',
                    'shipping_address' => 'Chroy Changvar, Phnom Penh',
                    'subtotal' => 400.00,
                    'discount_amount' => 0.00,
                    'tax_amount' => 0.00,
                    'total_amount' => 400.00,
                    'payment_method' => 'cash',
                    'payment_status' => 'unpaid',
                    'status' => 'pending',
                    'source' => 'web',
                    'notes' => 'រង់ចាំការទូទាត់',
                    'created_at' => now()->subMinutes(45),
                ],
            ];

            foreach ($sampleOrders as $orderData) {
                $order = Order::create($orderData);

                // Add 1 or 2 items
                $prod = $products->random();
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $prod->id,
                    'product_name' => $prod->name,
                    'price' => $prod->price,
                    'quantity' => 1,
                    'total' => $prod->price,
                ]);

                if ($products->count() > 1 && rand(0, 1)) {
                    $prod2 = $products->where('id', '!=', $prod->id)->first() ?? $prod;
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $prod2->id,
                        'product_name' => $prod2->name,
                        'price' => $prod2->price,
                        'quantity' => 1,
                        'total' => $prod2->price,
                    ]);
                }
            }
        }

        // 5. Sequence sync for PostgreSQL
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("SELECT setval(pg_get_serial_sequence('brands', 'id'), COALESCE((SELECT MAX(id) FROM brands), 1))");
            DB::statement("SELECT setval(pg_get_serial_sequence('coupons', 'id'), COALESCE((SELECT MAX(id) FROM coupons), 1))");
            DB::statement("SELECT setval(pg_get_serial_sequence('settings', 'id'), COALESCE((SELECT MAX(id) FROM settings), 1))");
            DB::statement("SELECT setval(pg_get_serial_sequence('orders', 'id'), COALESCE((SELECT MAX(id) FROM orders), 1))");
            DB::statement("SELECT setval(pg_get_serial_sequence('order_items', 'id'), COALESCE((SELECT MAX(id) FROM order_items), 1))");
        }
    }
}

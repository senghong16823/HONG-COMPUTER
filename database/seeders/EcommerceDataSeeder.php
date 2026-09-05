<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EcommerceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'name' => 'user',
                'email' => 'user@gmail.com',
                'is_admin' => false,
                'password' => '$2y$12$Duw4lg2u9F6hGwdko6ce4.D/uqalFS4EEh6.YWzxLEZwWjZROgXRC',
                'created_at' => '2026-08-18 23:09:42',
                'updated_at' => '2026-08-18 23:09:42',
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'is_admin' => true,
                'password' => '$2y$12$lQpD7gKBXe9RUV0feVvz9eorpuwQ6Bzpx.34SU6WK0v8ojcHA5E72',
                'created_at' => '2026-08-18 23:10:35',
                'updated_at' => '2026-08-18 23:30:26',
            ],
            [
                'id' => 3,
                'name' => 'Admin',
                'email' => 'admin@volunteer.com',
                'is_admin' => true,
                'password' => '$2y$12$bACmbNh05EwxNF5qh11IcuUMh9p14ntjwlearOwYKZNjvrVPbycHe',
                'created_at' => '2026-08-19 00:21:17',
                'updated_at' => '2026-08-19 00:21:17',
            ],
            [
                'id' => 4,
                'name' => 'Chantha SengHong',
                'email' => 'chanthasenghong@gmail.com',
                'is_admin' => true,
                'password' => '$2y$12$XFsjZ6eA6oxXlVJ8Oae7Pea6kkZU81aP75Kyikfz5Jx8TjTBq9ka6',
                'remember_token' => 'L6gjL0gwtKWdTxcA3HJOPUbzkvmACotxWQyc5AfMqGiKhQTR0aHaZjfc7zEl',
                'created_at' => '2026-08-26 22:20:52',
                'updated_at' => '2026-08-26 22:20:52',
            ],
        ];

        foreach ($users as $userData) {
            User::query()->updateOrCreate(
                ['id' => $userData['id']],
                $userData
            );
        }

        $categories = [
            [
                'id' => 1,
                'name' => 'Laptop Asus',
                'description' => null,
                'created_at' => '2026-08-26 23:13:38',
                'updated_at' => '2026-08-26 23:13:38',
            ],
            [
                'id' => 2,
                'name' => 'Desktop',
                'description' => null,
                'created_at' => '2026-08-26 23:37:47',
                'updated_at' => '2026-08-26 23:37:47',
            ],
            [
                'id' => 3,
                'name' => 'Laptop Lenovo',
                'description' => null,
                'created_at' => '2026-08-27 00:14:19',
                'updated_at' => '2026-08-27 00:14:19',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::query()->updateOrCreate(
                ['id' => $categoryData['id']],
                $categoryData
            );
        }

        $products = [
            [
                'id' => 1,
                'category_id' => 2,
                'name' => 'Dell',
                'price' => 400.00,
                'stock' => 4,
                'cpu' => 'I5 12th',
                'ram' => '8',
                'storage' => '512',
                'image' => 'uploads/products/1787812793.jpg',
                'description' => null,
                'created_at' => '2026-08-26 23:39:53',
                'updated_at' => '2026-08-26 23:54:32',
            ],
            [
                'id' => 2,
                'category_id' => 3,
                'name' => 'Lenovo ThinkPad',
                'price' => 1869.00,
                'stock' => 2,
                'cpu' => 'Intel® Core™ Ultra 7 Processor 258V ( Cores8,Threads8, Max Turbo 4.8GHz )',
                'ram' => '32GB DDR5',
                'storage' => 'Storage: SSD 512GB M2 PCIE',
                'image' => 'uploads/products/1787815012.jpg',
                'description' => "-CPU: Intel® Core™ Ultra 7 Processor 258V ( Cores8,Threads8, Max Turbo 4.8GHz )\r\n-RAM: 32GB DDR5\r\n-Storage: SSD 512GB M2 PCIE\r\n-Graphic: Intel® Arc 140v Graphics\r\n-Display : 15.3\"2.8K ( 2880 x 1800 ) OLED Touch Screen              \r\n-Wi-Fi + Bluetooth\r\nPorts\r\n1x USB-A (USB 10Gbps / USB 3.2 Gen 2), Always On\r\n2x USB-C® (Thunderbolt™ 4 / USB4® 40Gbps), with USB PD 15-65W and DisplayPort™ 2.1\r\n1x HDMI® 2.1, up to 4K/60Hz\r\n1x Headphone / microphone combo jack (3.5mm)\r\n-Weight: 1.40kg\r\n-Battery:  80Wh\r\n-OS: Win 11Pro License \r\n-Color:  Thunder Gray\r\nWarranty\r\n- 1-year hardware  \r\n- 6 Month for screen, keyboard & battery",
                'created_at' => '2026-08-27 00:16:52',
                'updated_at' => '2026-08-27 00:16:52',
            ],
            [
                'id' => 3,
                'category_id' => 3,
                'name' => 'Lenovo ThinkPad E16 Gen3 Core 5 210H-16GB-512 SSD-16" WUXGA-UMA-WLAN-FP-DOS-1Y',
                'price' => 1189.00,
                'stock' => 4,
                'cpu' => 'Intel® Core 5 210H',
                'ram' => '16GB DDR5 5600B',
                'storage' => 'SSD 512 GB',
                'image' => 'uploads/products/1787934075.jpg',
                'description' => "- CPU: Intel® Core 5 210H\r\n- OS: DOS (No operating system)\r\n- RAM: 16GB DDR5 5600B\r\n- Storage: SSD 512 GB\r\n- Graphic: Intel® Graphics\r\n- Display: 16\" WUXGA (1920x1200) IPS\r\n- Battery: 48Whr Li-Polymer\r\n- Keyboard Backlight +fingerprint\r\n- Weight: 1.63kg (3.17 lbs)\r\n- Warranty: 1 years",
                'created_at' => '2026-08-28 09:21:15',
                'updated_at' => '2026-08-28 09:21:15',
            ],
        ];

        foreach ($products as $productData) {
            Product::query()->updateOrCreate(
                ['id' => $productData['id']],
                $productData
            );
        }

        // Synchronize sequence values in PostgreSQL
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("SELECT setval(pg_get_serial_sequence('users', 'id'), COALESCE((SELECT MAX(id) FROM users), 1))");
            DB::statement("SELECT setval(pg_get_serial_sequence('categories', 'id'), COALESCE((SELECT MAX(id) FROM categories), 1))");
            DB::statement("SELECT setval(pg_get_serial_sequence('products', 'id'), COALESCE((SELECT MAX(id) FROM products), 1))");
        }
    }
}

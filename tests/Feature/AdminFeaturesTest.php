<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFeaturesTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_admin_dashboard_displays_stats(): void
    {
        $category = Category::create(['name' => 'Laptops']);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Test Laptop',
            'price' => 1200,
            'stock' => 10,
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('ទិដ្ឋភាពទូទៅ');
        $response->assertSee('ចំណូលសរុប');
    }

    public function test_pos_terminal_can_render_and_checkout(): void
    {
        $category = Category::create(['name' => 'Monitors']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Gaming Monitor 144Hz',
            'price' => 300,
            'stock' => 15,
        ]);

        // Access POS terminal
        $response = $this->actingAs($this->user)->get(route('admin.pos.index'));
        $response->assertOk();
        $response->assertSee('Gaming Monitor 144Hz');

        // Complete checkout via POS
        $checkoutData = [
            'customer_name' => 'Walk-in Customer',
            'customer_phone' => '012345678',
            'payment_method' => 'cash',
            'subtotal' => 600,
            'total_amount' => 600,
            'items' => [
                [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => 300,
                    'quantity' => 2,
                ],
            ],
        ];

        $checkoutResponse = $this->actingAs($this->user)->postJson(route('admin.pos.checkout'), $checkoutData);

        $checkoutResponse->assertOk();
        $checkoutResponse->assertJson([
            'success' => true,
        ]);

        // Verify stock deducted
        $this->assertEquals(13, $product->fresh()->stock);

        // Verify Order created
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Walk-in Customer',
            'customer_phone' => '012345678',
            'source' => 'pos',
            'total_amount' => 600,
            'status' => 'completed',
        ]);
    }

    public function test_order_management_and_status_update(): void
    {
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => 'Sok Dara',
            'customer_phone' => '098765432',
            'total_amount' => 1500,
            'source' => 'online',
            'payment_method' => 'khqr',
            'payment_status' => 'paid',
            'status' => 'pending',
        ]);

        // Access order list
        $response = $this->actingAs($this->user)->get(route('admin.orders.index'));
        $response->assertOk();
        $response->assertSee($order->order_number);

        // View invoice detail
        $showResponse = $this->actingAs($this->user)->get(route('admin.orders.show', $order));
        $showResponse->assertOk();
        $showResponse->assertSee('វិក្កយបត្រការបញ្ជាទិញ');
        $showResponse->assertSee('Sok Dara');

        // Update status
        $updateResponse = $this->actingAs($this->user)->patch(route('admin.orders.status', $order), [
            'status' => 'processing',
        ]);
        $updateResponse->assertRedirect();
        $this->assertEquals('processing', $order->fresh()->status);
    }

    public function test_brand_management_crud(): void
    {
        // Create brand
        $response = $this->actingAs($this->user)->post(route('brands.store'), [
            'name' => 'Apple',
            'description' => 'Think Different',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('brands.index'));
        $this->assertDatabaseHas('brands', [
            'name' => 'Apple',
            'slug' => 'apple',
        ]);
    }

    public function test_coupon_management_and_discount_calculation(): void
    {
        $coupon = Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => 50,
            'is_active' => true,
        ]);

        $this->assertTrue($coupon->isValid(100));
        $this->assertEquals(10, $coupon->calculateDiscount(100));

        $response = $this->actingAs($this->user)->get(route('admin.coupons.index'));
        $response->assertOk();
        $response->assertSee('WELCOME10');
    }

    public function test_reports_and_settings_accessible(): void
    {
        // Reports
        $reportResponse = $this->actingAs($this->user)->get(route('admin.reports.index'));
        $reportResponse->assertOk();
        $reportResponse->assertSee('ចំណូលលក់សរុប');

        // Settings
        $settingsResponse = $this->actingAs($this->user)->get(route('admin.settings.index'));
        $settingsResponse->assertOk();
        $settingsResponse->assertSee('ការកំណត់ប្រព័ន្ធ');

        // Update Settings
        $postSettings = $this->actingAs($this->user)->post(route('admin.settings.update'), [
            'store_name' => 'HONG COMPUTER UPDATED',
            'store_email' => 'admin@hongcomputer.com',
            'currency_symbol' => '$',
            'store_phone' => '012 999 888',
        ]);
        $postSettings->assertRedirect();
        $this->assertEquals('HONG COMPUTER UPDATED', Setting::get('store_name'));
    }

    public function test_customers_management_can_be_rendered(): void
    {
        $customer = User::factory()->create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
        ]);

        Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => '012345678',
            'total_amount' => 500,
            'source' => 'online',
            'payment_method' => 'khqr',
            'payment_status' => 'paid',
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.customers.index'));
        $response->assertOk();
        $response->assertSee('John Customer');

        $showResponse = $this->actingAs($this->user)->get(route('admin.customers.show', $customer));
        $showResponse->assertOk();
        $showResponse->assertSee('John Customer');
    }
}

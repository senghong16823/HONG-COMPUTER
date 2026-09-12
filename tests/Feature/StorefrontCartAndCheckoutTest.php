<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontCartAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    private Brand $brand;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::create(['name' => 'Gaming Laptops']);
        $this->brand = Brand::create(['name' => 'ASUS ROG', 'slug' => 'asus-rog', 'is_active' => true]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'ASUS ROG Zephyrus G16',
            'price' => 1800.00,
            'stock' => 10,
            'cpu' => 'Intel Core i9',
            'ram' => '32GB',
            'storage' => '1TB SSD',
        ]);
    }

    public function test_catalog_displays_products_and_filters(): void
    {
        $response = $this->get(route('shop.index', ['brand_id' => $this->brand->id]));

        $response->assertOk();
        $response->assertSee('ASUS ROG Zephyrus G16');
        $response->assertSee('ASUS ROG');
    }

    public function test_product_detail_page_renders_with_specs(): void
    {
        $response = $this->get(route('shop.show', $this->product));

        $response->assertOk();
        $response->assertSee('ASUS ROG Zephyrus G16');
        $response->assertSee('Intel Core i9');
        $response->assertSee('32GB');
        $response->assertSee('$1,800.00');
    }

    public function test_customer_can_add_item_to_cart_and_view_cart(): void
    {
        // Add to cart via POST
        $response = $this->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $this->assertCount(1, session('cart', []));
        $this->assertEquals(2, session('cart')[$this->product->id]['quantity']);

        // View Cart Page
        $cartPage = $this->get(route('cart.index'));
        $cartPage->assertOk();
        $cartPage->assertSee('ASUS ROG Zephyrus G16');
        $cartPage->assertSee('$3,600.00');
    }

    public function test_customer_can_update_quantities_and_remove_item(): void
    {
        // Seed cart in session
        session()->put('cart', [
            $this->product->id => [
                'product_id' => $this->product->id,
                'name' => $this->product->name,
                'price' => 1800.00,
                'image' => null,
                'category' => 'Gaming Laptops',
                'brand' => 'ASUS ROG',
                'quantity' => 1,
                'max_stock' => 10,
            ],
        ]);

        // Update quantity to 3
        $updateResp = $this->post(route('cart.update'), [
            'product_id' => $this->product->id,
            'quantity' => 3,
        ]);
        $updateResp->assertRedirect();
        $this->assertEquals(3, session('cart')[$this->product->id]['quantity']);

        // Remove item
        $removeResp = $this->post(route('cart.remove'), [
            'product_id' => $this->product->id,
        ]);
        $removeResp->assertRedirect();
        $this->assertEmpty(session('cart', []));
    }

    public function test_customer_can_apply_and_remove_coupon(): void
    {
        $coupon = Coupon::create([
            'code' => 'DISCOUNT50',
            'type' => 'fixed',
            'value' => 50,
            'min_order_amount' => 100,
            'is_active' => true,
        ]);

        session()->put('cart', [
            $this->product->id => [
                'product_id' => $this->product->id,
                'name' => $this->product->name,
                'price' => 1800.00,
                'image' => null,
                'category' => 'Gaming Laptops',
                'brand' => 'ASUS ROG',
                'quantity' => 1,
                'max_stock' => 10,
            ],
        ]);

        // Apply valid coupon
        $applyResp = $this->post(route('cart.coupon.apply'), ['code' => 'DISCOUNT50']);
        $applyResp->assertRedirect();
        $this->assertNotNull(session('coupon'));
        $this->assertEquals(50, session('coupon')['discount']);

        // Remove coupon
        $removeCouponResp = $this->post(route('cart.coupon.remove'));
        $removeCouponResp->assertRedirect();
        $this->assertNull(session('coupon'));
    }

    public function test_online_checkout_creates_order_and_deducts_inventory(): void
    {
        // Put item in cart
        session()->put('cart', [
            $this->product->id => [
                'product_id' => $this->product->id,
                'name' => $this->product->name,
                'price' => 1800.00,
                'image' => null,
                'category' => 'Gaming Laptops',
                'brand' => 'ASUS ROG',
                'quantity' => 2,
                'max_stock' => 10,
            ],
        ]);

        // Checkout Page loads
        $checkoutPage = $this->get(route('checkout.index'));
        $checkoutPage->assertOk();
        $checkoutPage->assertSee('ព័ត៌មានអតិថិជន');

        // Submit Checkout Form
        $checkoutData = [
            'customer_name' => 'Chanthy Online',
            'customer_phone' => '012987654',
            'customer_email' => 'chanthy@example.com',
            'shipping_address' => 'St 271, Sangkat Boeung Tumpun, Phnom Penh',
            'payment_method' => 'cod',
            'notes' => 'Please call before delivery',
        ];

        $postResp = $this->post(route('checkout.store'), $checkoutData);

        // Verify redirect to confirmation
        $postResp->assertRedirect();

        // Verify Order created in DB
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Chanthy Online',
            'customer_phone' => '012987654',
            'source' => 'online',
            'status' => 'pending',
            'payment_method' => 'cash',
        ]);

        $order = Order::where('customer_name', 'Chanthy Online')->first();
        $this->assertNotNull($order);

        // Verify OrderItem created
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        // Verify Product Stock deducted (10 - 2 = 8)
        $this->assertEquals(8, $this->product->fresh()->stock);

        // Verify Cart cleared from session
        $this->assertEmpty(session('cart', []));

        // Verify Confirmation page renders
        $confirmPage = $this->get(route('order.confirmation', $order->order_number));
        $confirmPage->assertOk();
        $confirmPage->assertSee($order->order_number);
        $confirmPage->assertSee('Chanthy Online');
    }

    public function test_guest_can_track_order_by_number_and_phone(): void
    {
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => 'Vannak Guest',
            'customer_phone' => '098112233',
            'shipping_address' => 'Siem Reap',
            'subtotal' => 1800,
            'total_amount' => 1802,
            'payment_method' => 'cash',
            'payment_status' => 'unpaid',
            'status' => 'processing',
            'source' => 'online',
        ]);

        $response = $this->get(route('order.track', [
            'order_number' => $order->order_number,
            'phone' => '098112233',
        ]));

        $response->assertOk();
        $response->assertSee($order->order_number);
        $response->assertSee('កំពុងរៀបចំ');
    }

    public function test_authenticated_customer_can_view_my_orders(): void
    {
        $user = User::factory()->create();

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_phone' => '012345678',
            'shipping_address' => 'Phnom Penh',
            'subtotal' => 500,
            'total_amount' => 500,
            'payment_method' => 'aba_khqr',
            'payment_status' => 'paid',
            'status' => 'completed',
            'source' => 'online',
        ]);

        $response = $this->actingAs($user)->get(route('customer.orders'));

        $response->assertOk();
        $response->assertSee($order->order_number);
        $response->assertSee('ការបញ្ជាទិញរបស់ខ្ញុំ');
    }
}

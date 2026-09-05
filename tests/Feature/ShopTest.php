<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_page_displays_products_and_categories(): void
    {
        $category = Category::create([
            'name' => 'Gaming Laptops',
            'description' => 'Powerful laptops for gaming',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'ROG Strix G16',
            'price' => 1499.99,
            'stock' => 5,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('ROG Strix G16');
        $response->assertSee('Gaming Laptops');
    }

    public function test_shop_can_search_products_by_name(): void
    {
        $category = Category::create(['name' => 'Ultrabooks']);

        Product::create([
            'category_id' => $category->id,
            'name' => 'MacBook Air M3',
            'price' => 1099.00,
            'stock' => 10,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Dell XPS 13',
            'price' => 1299.00,
            'stock' => 3,
        ]);

        $response = $this->get('/?search=MacBook');

        $response->assertOk();
        $response->assertSee('MacBook Air M3');
        $response->assertDontSee('Dell XPS 13');
    }

    public function test_shop_can_filter_products_by_category(): void
    {
        $cat1 = Category::create(['name' => 'Accessories']);
        $cat2 = Category::create(['name' => 'Monitors']);

        Product::create([
            'category_id' => $cat1->id,
            'name' => 'Logitech Mouse',
            'price' => 29.99,
            'stock' => 20,
        ]);

        Product::create([
            'category_id' => $cat2->id,
            'name' => 'Dell UltraSharp',
            'price' => 499.00,
            'stock' => 4,
        ]);

        $response = $this->get('/?category_id='.$cat1->id);

        $response->assertOk();
        $response->assertSee('Logitech Mouse');
        $response->assertDontSee('Dell UltraSharp');
    }

    public function test_product_detail_page_can_be_viewed(): void
    {
        $category = Category::create(['name' => 'Components']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'NVIDIA RTX 4080',
            'price' => 1199.99,
            'stock' => 2,
            'description' => 'Flagship graphics card',
        ]);

        $response = $this->get(route('shop.show', $product));

        $response->assertOk();
        $response->assertSee('NVIDIA RTX 4080');
        $response->assertSee('Flagship graphics card');
    }

    public function test_can_submit_review_for_product(): void
    {
        $category = Category::create(['name' => 'Audio']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Sony WH-1000XM5',
            'price' => 399.00,
            'stock' => 15,
        ]);

        $response = $this->post(route('reviews.store', $product), [
            'name' => 'Dara',
            'rating' => 5,
            'comment' => 'Exceptional noise cancellation!',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reviews', [
            'product_id' => $product->id,
            'name' => 'Dara',
            'rating' => 5,
            'comment' => 'Exceptional noise cancellation!',
        ]);
    }
}

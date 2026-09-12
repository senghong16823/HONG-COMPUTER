<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * បង្ហាញទំព័រដើម និងកាតាឡុកទំនិញ (Storefront Home & Catalog)
     */
    public function index(Request $request)
    {
        $categoryId = $request->get('category_id');
        $brandId = $request->get('brand_id');
        $search = $request->get('search');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $inStock = $request->boolean('in_stock');
        $sort = $request->get('sort', 'latest');

        $query = Product::with(['category', 'brand', 'reviews']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        if ($minPrice) {
            $query->where('price', '>=', (float) $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        if ($inStock) {
            $query->where('stock', '>', 0);
        }

        if ($search) {
            $operator = $query->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
            $query->where(function ($q) use ($search, $operator) {
                $q->where('name', $operator, "%{$search}%")
                    ->orWhere('cpu', $operator, "%{$search}%")
                    ->orWhere('ram', $operator, "%{$search}%")
                    ->orWhere('storage', $operator, "%{$search}%");
            });
        }

        // Sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::withCount('products')->get();
        $brands = Brand::where('is_active', true)->withCount('products')->orderBy('name')->get();

        $activeCoupons = Coupon::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
            })
            ->take(3)
            ->get();

        $featuredQuery = Product::with(['category', 'brand'])
            ->where('stock', '>', 0);

        if ($categoryId) {
            $featuredQuery->where('category_id', $categoryId);
        }

        if ($brandId) {
            $featuredQuery->where('brand_id', $brandId);
        }

        if ($search) {
            $operator = $query->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
            $featuredQuery->where(function ($q) use ($search, $operator) {
                $q->where('name', $operator, "%{$search}%")
                    ->orWhere('cpu', $operator, "%{$search}%")
                    ->orWhere('ram', $operator, "%{$search}%")
                    ->orWhere('storage', $operator, "%{$search}%");
            });
        }

        $featuredProducts = $featuredQuery->inRandomOrder()
            ->take(4)
            ->get();

        $currencySymbol = Setting::get('currency_symbol', '$');
        $maxDbPrice = Product::max('price') ?? 3000;

        return view('shop.index', compact(
            'products',
            'categories',
            'brands',
            'activeCoupons',
            'featuredProducts',
            'categoryId',
            'brandId',
            'search',
            'minPrice',
            'maxPrice',
            'inStock',
            'sort',
            'currencySymbol',
            'maxDbPrice'
        ));
    }

    /**
     * បង្ហាញព័ត៌មានលម្អិតកុំព្យូទ័រ (Product Detail Page)
     */
    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'reviews']);

        $relatedProducts = Product::with(['category', 'brand'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        $currencySymbol = Setting::get('currency_symbol', '$');

        return view('shop.show', compact('product', 'relatedProducts', 'currencySymbol'));
    }

    /**
     * ទទួលការវាយតម្លៃពីអតិថិជន (Store Review)
     */
    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product->reviews()->create([
            'name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'អរគុណសម្រាប់ការវាយតម្លៃរបស់អ្នក!');
    }
}

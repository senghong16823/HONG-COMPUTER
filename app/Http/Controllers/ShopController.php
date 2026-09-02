<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
   public function index(Request $request)
{
    // ចាប់យកទិន្នន័យពី URL (Category និង Search)
    $categoryId = $request->get('category_id');
    $search = $request->get('search');

    $products = Product::with('category')
        ->when($categoryId, function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })
        ->when($search, function ($query) use ($search) {
            // ស្វែងរកទំនិញដែលមានឈ្មោះស្រដៀងនឹងពាក្យដែលបានវាយបញ្ចូល
            return $query->where('name', 'like', "%{$search}%");
        })
        ->latest()
        ->get();

    $categories = Category::all();

    return view('shop.index', compact('products', 'categories', 'categoryId', 'search'));
}

public function show(Product $product)
    {
       $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->latest()
                                  ->take(4)
                                  ->get();

        // បញ្ជូនទិន្នន័យទាំង ២ ទៅកាន់ទំព័រ show.blade.php
        return view('shop.show', compact('product', 'relatedProducts'));
    }


    // មុខងារសម្រាប់រក្សាទុកការវាយតម្លៃ (Review)
    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $product->reviews()->create($request->all());

        return back()->with('success', 'អរគុណសម្រាប់ការវាយតម្លៃរបស់អ្នក!');
    }
}


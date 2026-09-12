<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * បង្ហាញតារាងបញ្ជីកុំព្យូទ័រ
     */
    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * បង្ហាញ Form សម្រាប់បញ្ចូលកុំព្យូទ័រថ្មី
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * ទទួលទិន្នន័យពី Form យកមក Save និង Upload រូបភាព
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/'.$imageName;
        }

        Product::create([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'cpu' => $request->cpu,
            'ram' => $request->ram,
            'storage' => $request->storage,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // បន្ទាប់ពី Save រួច ឲ្យវាលោតមកកាន់ទំព័រតារាងបញ្ជីវិញ (products.index)
        return redirect()->route('products.index')->with('success', 'កុំព្យូទ័រថ្មីត្រូវបានបញ្ចូលជោគជ័យ!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * បង្ហាញ Form សម្រាប់កែប្រែព័ត៌មានកុំព្យូទ័រ
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * ធ្វើបច្ចុប្បន្នភាព (Update) ទិន្នន័យចូល Database
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $product->image; // រក្សារូបភាពចាស់ទុកសិន បើគ្មានការ Upload ថ្មី

        if ($request->hasFile('image')) {
            // លុបរូបភាពចាស់ចោលប្រសិនបើមាន ដើម្បីកុំឲ្យកកស្ទះ Storage
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/'.$imageName;
        }

        $product->update([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'cpu' => $request->cpu,
            'ram' => $request->ram,
            'storage' => $request->storage,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'ព័ត៌មានកុំព្យូទ័រត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    /**
     * លុបទំនិញចេញពី Database
     */
    public function destroy(Product $product)
    {
        // លុបរូបភាពចេញពី Folder ផងដែរ
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'កុំព្យូទ័រត្រូវបានលុបចេញពីប្រព័ន្ធ!');
    }
}

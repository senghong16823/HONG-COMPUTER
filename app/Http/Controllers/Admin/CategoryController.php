<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // ១. ទាញទិន្នន័យទាំងអស់ទៅបង្ហាញលើតារាង
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // ២. បង្ហាញទំព័រ Form សម្រាប់បញ្ចូលទិន្នន័យថ្មី
    public function create()
    {
        return view('admin.categories.create');
    }

    // ៣. ទទួលទិន្នន័យពី Form យកមក Save ចូល Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'icon' => $request->icon,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'ប្រភេទកុំព្យូទ័រត្រូវបានបង្កើតដោយជោគជ័យ!');
    }

    // ៤. បង្ហាញ Form កែប្រែ (ប្រកាស View ឱ្យត្រូវ Folder admin.categories.edit)
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // ៥. រក្សាទុកការកែប្រែ
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'កែប្រែប្រភេទទំនិញជោគជ័យ!');
    }

    // ៦. លុបទិន្នន័យ
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'លុបប្រភេទទំនិញជោគជ័យ!');
    }
}
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
        // កំណត់លក្ខខណ្ឌថា "ឈ្មោះ" ត្រូវតែវាយបញ្ចូល
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'ប្រភេទកុំព្យូទ័រត្រូវបានបង្កើតដោយជោគជ័យ!');
    }
}
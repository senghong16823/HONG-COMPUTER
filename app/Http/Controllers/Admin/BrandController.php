<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->paginate(15);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time().'_'.Str::slug($request->name).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/brands'), $filename);
            $logoPath = 'uploads/brands/'.$filename;
        }

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'logo' => $logoPath,
            'website' => $request->website,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('brands.index')->with('success', 'ម៉ាកយីហោថ្មីត្រូវបានបង្កើតជោគជ័យ!');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $logoPath = $brand->logo;
        if ($request->hasFile('logo')) {
            if ($brand->logo && file_exists(public_path($brand->logo))) {
                unlink(public_path($brand->logo));
            }
            $file = $request->file('logo');
            $filename = time().'_'.Str::slug($request->name).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/brands'), $filename);
            $logoPath = 'uploads/brands/'.$filename;
        }

        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'logo' => $logoPath,
            'website' => $request->website,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('brands.index')->with('success', 'ព័ត៌មានម៉ាកយីហោត្រូវបានកែប្រែជោគជ័យ!');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo && file_exists(public_path($brand->logo))) {
            unlink(public_path($brand->logo));
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'ម៉ាកយីហោត្រូវបានលុបចេញពីប្រព័ន្ធ!');
    }
}

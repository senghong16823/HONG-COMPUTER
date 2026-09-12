<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'store_name' => Setting::get('store_name', 'HONG COMPUTER'),
            'store_email' => Setting::get('store_email', 'contact@hongcomputer.com'),
            'store_phone' => Setting::get('store_phone', '093 757 079 / 012 345 678'),
            'store_address' => Setting::get('store_address', 'ផ្លូវ 271, រាជធានីភ្នំពេញ, ប្រទេសកម្ពុជា'),
            'currency_symbol' => Setting::get('currency_symbol', '$'),
            'tax_rate' => Setting::get('tax_rate', '0'),
            'shipping_fee' => Setting::get('shipping_fee', '2.00'),
            'facebook_page' => Setting::get('facebook_page', 'https://facebook.com/hongcomputer'),
            'telegram_number' => Setting::get('telegram_number', '093 757 079'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_email' => 'required|email|max:255',
            'store_phone' => 'nullable|string|max:255',
            'store_address' => 'nullable|string|max:500',
            'currency_symbol' => 'required|string|max:10',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'shipping_fee' => 'nullable|numeric|min:0',
            'facebook_page' => 'nullable|string|max:255',
            'telegram_number' => 'nullable|string|max:255',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        return redirect()->route('admin.settings.index')->with('success', 'ការកំណត់ត្រូវបានរក្សាទុកដោយជោគជ័យ!');
    }
}

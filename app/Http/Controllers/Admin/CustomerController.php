<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = User::withCount('orders')
            ->withSum(['orders as total_spent' => function ($q) {
                $q->where('payment_status', 'paid');
            }], 'total_amount')
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers', 'search'));
    }

    public function show(User $customer)
    {
        $customer->load(['orders' => function ($q) {
            $q->latest();
        }, 'orders.items']);

        $totalSpent = $customer->orders->where('payment_status', 'paid')->sum('total_amount');
        $ordersCount = $customer->orders->count();

        return view('admin.customers.show', compact('customer', 'totalSpent', 'ordersCount'));
    }
}

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.customers.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                <i class="fa-solid fa-arrow-left text-lg"></i>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('ព័ត៌មានលម្អិតអំពីអតិថិជន') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Customer Summary Profile -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-blue-600 text-white font-bold flex items-center justify-center text-2xl shadow-md shadow-blue-500/20">
                        {{ mb_substr($customer->name, 0, 1, 'UTF-8') }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">{{ $customer->name }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5"><i class="fa-solid fa-envelope me-1"></i> {{ $customer->email }}</p>
                        <p class="text-xs text-slate-400 mt-0.5"><i class="fa-solid fa-calendar me-1"></i> ចុះឈ្មោះនៅ៖ {{ $customer->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-6 divide-x divide-slate-100">
                    <div class="text-center px-4">
                        <span class="text-xs text-slate-400 font-medium">ការបញ្ជាទិញសរុប</span>
                        <p class="text-2xl font-bold text-slate-900">{{ $ordersCount }}</p>
                    </div>
                    <div class="text-center px-4">
                        <span class="text-xs text-slate-400 font-medium">ចំណាយសរុប</span>
                        <p class="text-2xl font-bold text-emerald-600">${{ number_format($totalSpent, 2) }}</p>
                    </div>
                    <div class="text-center px-4">
                        <span class="text-xs text-slate-400 font-medium">តួនាទី</span>
                        <p class="text-sm font-bold mt-1">
                            <span class="px-2.5 py-0.5 rounded-full {{ $customer->is_admin ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }}">
                                {{ $customer->is_admin ? 'Admin' : 'Customer' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Customer Purchase History Table -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6 space-y-4">
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-blue-600"></i>
                    <span>ប្រវត្តិនៃការបញ្ជាទិញទំនិញ (Order History)</span>
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                                <th class="p-3">លេខកូដកុម្ម៉ង់</th>
                                <th class="p-3">កាលបរិច្ឆេទ</th>
                                <th class="p-3">មុខទំនិញ</th>
                                <th class="p-3">តម្លៃសរុប</th>
                                <th class="p-3">ស្ថានភាព</th>
                                <th class="p-3 text-center">វិក្កយបត្រ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            @forelse($customer->orders as $order)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-3 font-bold text-blue-600">#{{ $order->order_number }}</td>
                                    <td class="p-3 text-xs text-slate-400">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="p-3 text-xs text-slate-600 max-w-xs truncate">
                                        {{ $order->items->pluck('product_name')->implode(', ') ?: '—' }}
                                    </td>
                                    <td class="p-3 font-bold text-slate-900">${{ number_format($order->total_amount, 2) }}</td>
                                    <td class="p-3">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold
                                            {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($order->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs text-blue-600 hover:underline">
                                            មើលវិក្កយបត្រ
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-400">
                                        អតិថិជននេះមិនទាន់មានការបញ្ជាទិញទំនិញណាមួយនៅឡើយទេ
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

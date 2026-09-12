<x-app-layout>
    {{-- Slot Header Filter & Quick Action --}}
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <!-- Left (Title) -->
            <h2 class="text-xl font-bold text-slate-900 leading-tight flex items-center gap-2">
                <i class="fa-solid fa-chart-pie text-blue-600"></i>
                {{ __('ទិដ្ឋភាពទូទៅ (Dashboard Overview)') }}
            </h2>
    
            <!-- Right (Filter & Button) -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.reports.index') }}"
                    class="flex items-center gap-2 px-3.5 py-2 border border-slate-200 bg-white text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm">
                    <i class="fa-solid fa-file-invoice-dollar text-slate-500"></i>
                    <span>របាយការណ៍លម្អិត</span>
                </a>
    
                <!-- Quick POS Button -->
                <a href="{{ route('admin.pos.index') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm group">
                    <i class="fa-solid fa-cash-register group-hover:scale-110 transition-transform"></i>
                    <span>បើក POS លក់រាយ</span>
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Body Main Content --}}
    <div class="py-6 min-h-screen text-slate-800 font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 1. STATS CARDS (4 ប្រអប់ E-commerce Standard) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- 1.1 Revenue Card -->
                <div
                    class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">ចំណូលសរុប
                            (Revenue)</span>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-lg transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-dollar-sign text-lg"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">${{ number_format($totalRevenue, 2) }}</p>
                        <p class="text-sm text-emerald-600 mt-2 flex items-center gap-1 font-medium">
                            <i class="fa-solid fa-circle-check"></i> ទូទាត់រួចរាល់
                        </p>
                    </div>
                </div>

                <!-- 1.2 Orders Card -->
                <div
                    class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">ការបញ្ជាទិញ
                            (Orders)</span>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-bag-shopping text-lg"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">{{ $totalOrders }}</p>
                        <p class="text-sm text-blue-600 mt-2 flex items-center gap-1 font-medium">
                            <i class="fa-solid fa-truck-fast"></i> {{ $processingOrders }} កំពុងដំណើរការ
                        </p>
                    </div>
                </div>

                <!-- 1.3 Customers Card -->
                <div
                    class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">អតិថិជនសរុប
                            (Customers)</span>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-purple-50 text-purple-600 rounded-lg transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-users text-lg"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">{{ $totalCustomers }}</p>
                        <a href="{{ route('admin.customers.index') }}" class="text-sm text-purple-600 mt-2 flex items-center gap-1 font-medium hover:underline">
                            <i class="fa-solid fa-arrow-right text-xs"></i> មើលបញ្ជីអតិថិជន
                        </a>
                    </div>
                </div>

                <!-- 1.4 Stock Alert Card -->
                <div
                    class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">ព្រមានស្តុក
                            (Stock Alert)</span>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 rounded-lg transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-red-600">{{ $lowStockCount }} <span
                                class="text-sm font-normal text-slate-500">មុខទំនិញ</span></p>
                        <a href="{{ route('products.index') }}"
                            class="text-sm text-red-500 mt-2 flex items-center gap-1 font-medium hover:underline">
                            គ្រប់គ្រងស្តុកទំនិញ <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

            </div>

            <!-- 2. DATA TABLES & LISTS (Grid 12 Cols) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- 2.1 Recent Orders Table (Col 8) -->
                <div class="lg:col-span-8 bg-white border border-slate-100 rounded-xl shadow-sm">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-blue-600"></i>
                            <span>ការបញ្ជាទិញថ្មីៗ (Recent Orders)</span>
                        </h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-blue-600 hover:underline">មើលទាំងអស់</a>
                    </div>

                    <div class="overflow-x-auto p-2">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead>
                                <tr class="text-slate-500 uppercase text-xs border-b border-slate-100 bg-slate-50">
                                    <th class="py-3 px-4 font-medium">លេខកូដ / អតិថិជន</th>
                                    <th class="py-3 px-4 font-medium">ទំនិញ (Items)</th>
                                    <th class="py-3 px-4 font-medium">តម្លៃសរុប</th>
                                    <th class="py-3 px-4 font-medium">ប្រភព</th>
                                    <th class="py-3 px-4 font-medium">ស្ថានភាព</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($recentOrders as $order)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="py-3 px-4">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="font-bold text-blue-600 hover:underline">
                                                #{{ $order->order_number }}
                                            </a>
                                            <p class="text-slate-500 text-xs">{{ $order->customer_name }}</p>
                                        </td>
                                        <td class="py-3 px-4 max-w-xs truncate">
                                            <p class="font-medium text-slate-800 truncate">
                                                {{ $order->items->pluck('product_name')->implode(', ') ?: '—' }}
                                            </p>
                                            <p class="text-slate-400 text-xs">{{ $order->items->sum('quantity') }} មុខ</p>
                                        </td>
                                        <td class="py-3 px-4 font-bold text-slate-900">${{ number_format($order->total_amount, 2) }}</td>
                                        <td class="py-3 px-4">
                                            @if($order->source === 'pos')
                                                <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-[11px] font-semibold rounded">POS</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-[11px] font-semibold rounded">Web</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($order->status === 'completed')
                                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">Completed</span>
                                            @elseif($order->status === 'pending')
                                                <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">Pending</span>
                                            @elseif($order->status === 'processing')
                                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Processing</span>
                                            @else
                                                <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-full">Cancelled</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-400">
                                            មិនទាន់មានការបញ្ជាទិញថ្មីៗនៅឡើយទេ
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2.2 Top Selling Products (Col 4) -->
                <div class="lg:col-span-4 bg-white border border-slate-100 rounded-xl shadow-sm">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                            <i class="fa-solid fa-fire text-amber-500"></i>
                            <span>លក់ដាច់បំផុត (Top Selling)</span>
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        @forelse($topProducts as $item)
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center shrink-0 border border-slate-200">
                                    @if($item->image)
                                        <img src="{{ asset($item->image) }}" class="w-full h-full object-cover rounded-xl" alt="{{ $item->name }}">
                                    @else
                                        <i class="fa-solid fa-laptop text-slate-500 text-xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-slate-900 text-sm truncate">{{ $item->name }}</p>
                                    <div class="flex items-center justify-between mt-1">
                                        <p class="text-slate-500 text-xs">លក់បាន {{ $item->sold_count ?? 0 }} គ្រឿង</p>
                                        <p class="text-emerald-600 text-xs font-bold">${{ number_format($item->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-slate-400 py-6 text-sm">មិនទាន់មានទិន្នន័យលក់នៅឡើយ</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
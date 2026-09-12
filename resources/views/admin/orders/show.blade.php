<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('វិក្កយបត្រការបញ្ជាទិញ') }} #{{ $order->order_number }}
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 transition flex items-center gap-2 cursor-pointer shadow-sm">
                    <i class="fa-solid fa-print"></i> បោះពុម្ពវិក្កយបត្រ (Print)
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Alert --}}
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                        <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Invoice Card -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-8 space-y-8 print:shadow-none print:border-none print:p-0">
                
                <!-- Invoice Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start gap-6 border-b border-slate-100 pb-8">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-sm">
                                <i class="fa-solid fa-store text-amber-500"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-slate-900">HONG COMPUTER</h1>
                                <p class="text-xs text-slate-500">ហាងលក់កុំព្យូទ័រ និងសម្ភារៈអេឡិចត្រូនិក</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-3">ទូរស័ព្ទ៖ 093 757 079 / 012 345 678</p>
                        <p class="text-xs text-slate-500">អាសយដ្ឋាន៖ ផ្លូវ 271, រាជធានីភ្នំពេញ</p>
                    </div>

                    <div class="sm:text-right space-y-1">
                        <span class="text-xs uppercase font-bold tracking-widest text-slate-400">វិក្កយបត្រ (INVOICE)</span>
                        <h3 class="text-2xl font-bold text-blue-600">#{{ $order->order_number }}</h3>
                        <p class="text-xs text-slate-500">កាលបរិច្ឆេទ៖ {{ $order->created_at->format('d F Y, h:i A') }}</p>
                        <p class="text-xs text-slate-500">ប្រភព៖ <span class="uppercase font-semibold text-slate-700">{{ $order->source }}</span></p>
                    </div>
                </div>

                <!-- Customer & Payment Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50 p-6 rounded-2xl border border-slate-100/80">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">ព័ត៌មានអតិថិជន</h4>
                        <p class="font-bold text-slate-900 text-base">{{ $order->customer_name }}</p>
                        @if($order->customer_phone)
                            <p class="text-xs text-slate-600 mt-1"><i class="fa-solid fa-phone text-slate-400 me-1"></i> {{ $order->customer_phone }}</p>
                        @endif
                        @if($order->customer_email)
                            <p class="text-xs text-slate-600"><i class="fa-solid fa-envelope text-slate-400 me-1"></i> {{ $order->customer_email }}</p>
                        @endif
                        @if($order->shipping_address)
                            <p class="text-xs text-slate-600 mt-2"><i class="fa-solid fa-location-dot text-slate-400 me-1"></i> {{ $order->shipping_address }}</p>
                        @endif
                    </div>

                    <div class="md:text-right space-y-1">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">ការទូទាត់ & ស្ថានភាព</h4>
                        <p class="text-xs text-slate-600">វិធីសាស្ត្រ៖ <span class="font-bold uppercase text-slate-800">{{ str_replace('_', ' ', $order->payment_method) }}</span></p>
                        <p class="text-xs text-slate-600">ស្ថានភាពទូទាត់៖ 
                            @if($order->payment_status === 'paid')
                                <span class="font-bold text-emerald-600">បានបង់ប្រាក់ (Paid)</span>
                            @else
                                <span class="font-bold text-amber-600">មិនទាន់បង់ (Unpaid)</span>
                            @endif
                        </p>
                        <p class="text-xs text-slate-600">ស្ថានភាពទំនិញ៖ 
                            <span class="font-bold capitalize text-blue-600">{{ $order->status }}</span>
                        </p>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs uppercase text-slate-500 font-semibold">
                                <th class="py-3 px-2">ល.រ</th>
                                <th class="py-3 px-4">ឈ្មោះទំនិញ</th>
                                <th class="py-3 px-4 text-center">តម្លៃរាយ</th>
                                <th class="py-3 px-4 text-center">ចំនួន</th>
                                <th class="py-3 px-4 text-right">តម្លៃសរុប</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($order->items as $index => $item)
                                <tr>
                                    <td class="py-4 px-2 text-slate-400 font-medium">{{ $index + 1 }}</td>
                                    <td class="py-4 px-4 font-bold text-slate-800">
                                        {{ $item->product_name }}
                                    </td>
                                    <td class="py-4 px-4 text-center text-slate-600">${{ number_format($item->price, 2) }}</td>
                                    <td class="py-4 px-4 text-center font-bold text-slate-800">{{ $item->quantity }}</td>
                                    <td class="py-4 px-4 text-right font-bold text-slate-900">${{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Invoice Summary -->
                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <div class="w-72 space-y-2 text-sm text-slate-600">
                        <div class="flex justify-between">
                            <span>តម្លៃទំនិញសរុប (Subtotal)</span>
                            <span class="font-semibold text-slate-900">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between text-emerald-600">
                                <span>បញ្ចុះតម្លៃ (Discount)</span>
                                <span class="font-semibold">-${{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        @if($order->tax_amount > 0)
                            <div class="flex justify-between">
                                <span>ពន្ធ (Tax)</span>
                                <span class="font-semibold text-slate-900">${{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-lg font-bold text-slate-900 pt-3 border-t border-slate-200">
                            <span>សរុបចុងក្រោយ (Total)</span>
                            <span class="text-blue-600 text-2xl">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($order->notes)
                    <div class="p-4 bg-amber-50/70 border border-amber-200/60 rounded-xl text-xs text-amber-900">
                        <span class="font-bold">កំណត់សម្គាល់៖</span> {{ $order->notes }}
                    </div>
                @endif

            </div>

            <!-- Status Updater Panel (Hidden on print) -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 print:hidden">
                <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-blue-600"></i>
                    <span>កែប្រែស្ថានភាពការបញ្ជាទិញ</span>
                </h3>

                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">ស្ថានភាពការបញ្ជាទិញ (Order Status)</label>
                        <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>រង់ចាំ (Pending)</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>កំពុងរៀបចំ (Processing)</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>បានបញ្ចប់ (Completed)</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>បោះបង់ (Cancelled)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">ស្ថានភាពទូទាត់ប្រាក់ (Payment Status)</label>
                        <select name="payment_status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>បានបង់ប្រាក់ (Paid)</option>
                            <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>មិនទាន់បង់ (Unpaid)</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>សងប្រាក់វិញ (Refunded)</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition cursor-pointer shadow-sm">
                            <i class="fa-solid fa-check me-1"></i> រក្សាទុកស្ថានភាពថ្មី
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

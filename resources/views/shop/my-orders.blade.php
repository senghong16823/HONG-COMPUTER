<x-storefront-layout title="ការបញ្ជាទិញរបស់ខ្ញុំ (My Orders)">

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <a href="{{ route('shop.index') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                    <i class="fa-solid fa-house text-[10px]"></i> ទំព័រដើម
                </a>
                <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                <span class="text-slate-800 font-bold">ការបញ្ជាទិញរបស់ខ្ញុំ</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 flex items-center gap-2.5">
                    <i class="fa-solid fa-box-archive text-blue-600"></i>
                    <span>ប្រវត្តិការបញ្ជាទិញរបស់ខ្ញុំ (My Orders)</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    ពិនិត្យមើលរាល់ការបញ្ជាទិញទំនិញ និងតាមដានស្ថានភាពដឹកជញ្ជូន
                </p>
            </div>

            <a href="{{ route('shop.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-bag-shopping"></i> ទិញទំនិញថ្មី
            </a>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-4 hover:border-blue-300 transition">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border-b border-slate-100 pb-4 text-xs">
                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="font-bold text-slate-900 font-mono text-sm">#{{ $order->order_number }}</span>
                                <span class="text-slate-400">|</span>
                                <span class="text-slate-500">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                                <span class="text-slate-400">|</span>
                                <span class="text-slate-600 font-semibold">{{ $order->items->count() }} មុខទំនិញ</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- Status Badge -->
                                @if($order->status === 'completed')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-check-circle mr-1"></i> បានបញ្ចប់
                                    </span>
                                @elseif($order->status === 'processing')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800">
                                        <i class="fa-solid fa-spinner fa-spin mr-1"></i> កំពុងរៀបចំ
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">
                                        <i class="fa-solid fa-ban mr-1"></i> បានបោះបង់
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                        <i class="fa-solid fa-clock mr-1"></i> កំពុងរង់ចាំ
                                    </span>
                                @endif

                                <!-- Payment Status -->
                                @if($order->payment_status === 'paid')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ទូទាត់រួច
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        មិនទាន់ទូទាត់
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Items Preview List -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-3 p-2 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                    <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center p-1 shrink-0">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset($item->product->image) }}" class="max-h-full max-w-full object-contain">
                                        @else
                                            <i class="fa-solid fa-laptop text-slate-300"></i>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-bold text-slate-800 truncate">{{ $item->product_name }}</p>
                                        <p class="text-[11px] text-slate-500">${{ number_format($item->price, 2) }} x {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 text-xs">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-500">ទឹកប្រាក់សរុប៖</span>
                                <span class="text-lg font-extrabold text-red-600 font-sans">${{ number_format($order->total_amount, 2) }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('order.confirmation', $order->order_number) }}"
                                   class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                                    <i class="fa-solid fa-file-invoice"></i> មើលវិក្កយបត្រ & តាមដាន
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div>
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            <!-- Empty Orders State -->
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-md mx-auto shadow-sm space-y-4">
                <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-500 mx-auto flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">មិនទាន់មានការបញ្ជាទិញទេ</h3>
                <p class="text-xs text-slate-400">
                    លោកអ្នកមិនទាន់បានបញ្ជាទិញផលិតផលណាមួយពីហាងយើងខ្ញុំនៅឡើយទេ។
                </p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition">
                    <i class="fa-solid fa-laptop"></i> ចាប់ផ្តើមទិញទំនិញ
                </a>
            </div>
        @endif

    </div>

</x-storefront-layout>

<x-storefront-layout title="តាមដានការបញ្ជាទិញ (Order Tracking)">

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <a href="{{ route('shop.index') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                    <i class="fa-solid fa-house text-[10px]"></i> ទំព័រដើម
                </a>
                <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                <span class="text-slate-800 font-bold">តាមដានការបញ្ជាទិញ</span>
            </nav>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">

        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 mx-auto flex items-center justify-center text-2xl shadow-sm">
                <i class="fa-solid fa-route"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                តាមដានការបញ្ជាទិញរបស់អ្នក
            </h1>
            <p class="text-xs text-slate-500 max-w-md mx-auto">
                សូមបញ្ចូលលេខកូដវិក្កយបត្រ និងលេខទូរស័ព្ទដែលបានប្រើប្រាស់ពេលកុម្ម៉ង់ទំនិញ ដើម្បីពិនិត្យមើលស្ថានភាពដឹកជញ្ជូន។
            </p>
        </div>

        <!-- Search Form Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
            <form action="{{ route('order.track') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            លេខកូដបញ្ជាទិញ (Order Number) *
                        </label>
                        <input type="text" name="order_number" value="{{ $orderNumber }}" required
                               placeholder="ឧ. ORD-20260912-1234"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono uppercase focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            លេខទូរស័ព្ទរបស់អ្នក (Phone Number) *
                        </label>
                        <input type="text" name="phone" value="{{ $phone }}" required
                               placeholder="ឧ. 012 345 678"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20 flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>ស្វែងរក & តាមដាន (Track Order)</span>
                </button>
            </form>
        </div>

        <!-- Result Section -->
        @if($searched)
            @if($order)
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6 animate-fade-in">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border-b border-slate-100 pb-4">
                        <div>
                            <span class="text-xs text-slate-400">លទ្ធផលសម្រាប់៖</span>
                            <h2 class="text-lg font-bold text-slate-900 font-mono">#{{ $order->order_number }}</h2>
                            <p class="text-[11px] text-slate-500">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                        </div>

                        <!-- Status Badge -->
                        <div>
                            @if($order->status === 'completed')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                    <i class="fa-solid fa-circle-check mr-1"></i> បានបញ្ចប់ការដឹកជញ្ជូន
                                </span>
                            @elseif($order->status === 'processing')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                    <i class="fa-solid fa-spinner fa-spin mr-1"></i> កំពុងរៀបចំ និងដឹកជញ្ជូន
                                </span>
                            @elseif($order->status === 'cancelled')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                    <i class="fa-solid fa-ban mr-1"></i> បានបោះបង់
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                    <i class="fa-solid fa-clock mr-1"></i> កំពុងរង់ចាំការបញ្ជាក់
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline Indicator -->
                    <div class="grid grid-cols-3 gap-2 text-center text-xs py-2">
                        <div class="space-y-1">
                            <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center mx-auto text-xs font-bold">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <p class="font-bold text-slate-800">បានកុម្ម៉ង់</p>
                        </div>
                        <div class="space-y-1">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mx-auto text-xs font-bold {{ in_array($order->status, ['processing', 'completed']) ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-400' }}">
                                <i class="fa-solid {{ in_array($order->status, ['processing', 'completed']) ? 'fa-check' : 'fa-spinner' }}"></i>
                            </div>
                            <p class="font-bold text-slate-800">កំពុងរៀបចំ</p>
                        </div>
                        <div class="space-y-1">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mx-auto text-xs font-bold {{ $order->status === 'completed' ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-400' }}">
                                <i class="fa-solid {{ $order->status === 'completed' ? 'fa-check' : 'fa-truck' }}"></i>
                            </div>
                            <p class="font-bold text-slate-800">ដឹកដល់</p>
                        </div>
                    </div>

                    <!-- Items Summary -->
                    <div class="space-y-2 border-t border-slate-100 pt-4 text-xs">
                        <p class="font-bold text-slate-700">មុខទំនិញដែលបានបញ្ជាទិញ៖</p>
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center py-1 text-slate-600">
                                <span>{{ $item->product_name }} (x{{ $item->quantity }})</span>
                                <span class="font-bold text-slate-800 font-sans">${{ number_format($item->total, 2) }}</span>
                            </div>
                        @endforeach
                        <div class="pt-2 border-t border-slate-100 flex justify-between items-center text-sm font-bold text-slate-900">
                            <span>ទឹកប្រាក់សរុប</span>
                            <span class="text-red-600 font-extrabold font-sans">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <!-- Action Link -->
                    <div class="pt-2 text-right">
                        <a href="{{ route('order.confirmation', $order->order_number) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-sm transition">
                            <i class="fa-solid fa-file-invoice"></i> មើលវិក្កយបត្រពេញលេញ
                        </a>
                    </div>
                </div>
            @else
                <div class="p-6 bg-rose-50 border border-rose-200 rounded-3xl text-center space-y-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-2xl"></i>
                    <p class="text-sm font-bold text-rose-800">រកមិនឃើញការបញ្ជាទិញនេះទេ</p>
                    <p class="text-xs text-rose-600">
                        សូមពិនិត្យមើលលេខកូដវិក្កយបត្រ និងលេខទូរស័ព្ទរបស់អ្នកឡើងវិញឱ្យបានត្រឹមត្រូវ។
                    </p>
                </div>
            @endif
        @endif

    </div>

</x-storefront-layout>

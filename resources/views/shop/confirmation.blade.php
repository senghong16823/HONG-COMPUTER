<x-storefront-layout :title="'ការបញ្ជាទិញជោគជ័យ #' . $order->order_number">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

        <!-- 1. Success Celebration Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 sm:p-12 text-center space-y-4">
            <div class="w-20 h-20 rounded-full bg-emerald-50 text-emerald-600 mx-auto flex items-center justify-center text-4xl shadow-sm animate-bounce">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div class="space-y-1">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold">
                    ការបញ្ជាទិញទទួលបានជោគជ័យ
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 pt-2">
                    អរគុណសម្រាប់ការបញ្ជាទិញរបស់អ្នក!
                </h1>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    យើងខ្ញុំបានទទួលព័ត៌មានការបញ្ជាទិញរបស់លោកអ្នករួចរាល់ហើយ។ ក្រុមការងារនឹងទាក់ទងមកលោកអ្នកក្នុងពេលឆាប់ៗនេះ។
                </p>
            </div>

            <div class="inline-flex items-center gap-3 px-5 py-2.5 bg-slate-50 rounded-2xl border border-slate-200 text-xs">
                <span class="text-slate-400">លេខកូដវិក្កយបត្រ៖</span>
                <strong class="text-slate-900 font-mono font-bold text-sm">#{{ $order->order_number }}</strong>
                <span class="text-slate-300">|</span>
                <span class="text-slate-500">{{ $order->created_at->format('d M Y, h:i A') }}</span>
            </div>
        </div>

        <!-- 2. Order Tracking Timeline -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-route text-blue-600"></i>
                <span>ដំណាក់កាលដំណើរការ (Order Status Timeline)</span>
            </h3>

            @php
                $isPending = in_array($order->status, ['pending', 'processing', 'completed']);
                $isProcessing = in_array($order->status, ['processing', 'completed']);
                $isCompleted = ($order->status === 'completed');
                $isCancelled = ($order->status === 'cancelled');
            @endphp

            @if($isCancelled)
                <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-center text-xs text-rose-700 font-bold">
                    <i class="fa-solid fa-triangle-exclamation mr-1"></i> ការបញ្ជាទិញនេះត្រូវបានបោះបង់ (Cancelled)
                </div>
            @else
                <div class="grid grid-cols-3 gap-2 pt-2 text-center text-xs">
                    <!-- Step 1 -->
                    <div class="space-y-2">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center font-bold text-sm {{ $isPending ? 'bg-emerald-500 text-white shadow-md' : 'bg-slate-100 text-slate-400' }}">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">បានកុម្ម៉ង់</p>
                            <p class="text-[10px] text-slate-400">Order Placed</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="space-y-2">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center font-bold text-sm {{ $isProcessing ? 'bg-emerald-500 text-white shadow-md' : 'bg-slate-100 text-slate-400' }}">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">កំពុងរៀបចំ</p>
                            <p class="text-[10px] text-slate-400">Processing</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="space-y-2">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center font-bold text-sm {{ $isCompleted ? 'bg-emerald-500 text-white shadow-md' : 'bg-slate-100 text-slate-400' }}">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">បានបញ្ចប់ & ដឹកដល់</p>
                            <p class="text-[10px] text-slate-400">Completed</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- 3. KHQR Payment Prompt (If KHQR Selected) -->
        @if($order->payment_method === 'aba_khqr')
            <div class="bg-gradient-to-br from-red-600 to-rose-700 text-white rounded-3xl p-6 sm:p-8 shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-3 max-w-md">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold">
                        <i class="fa-solid fa-qrcode"></i> ទូទាត់តាម KHQR
                    </div>
                    <h3 class="text-xl font-bold">សូមស្កេនទូទាត់ប្រាក់ឥឡូវនេះ</h3>
                    <p class="text-xs text-rose-100 leading-relaxed">
                        លោកអ្នកអាចប្រើប្រាស់ App ធនាគារណាមួយ (ABA, Bakong, Acleda...) ដើម្បីស្កេនទូទាត់ប្រាក់ចំនួន
                        <strong class="text-white text-sm underline">${{ number_format($order->total_amount, 2) }}</strong>
                    </p>
                    <div class="text-xs text-rose-200">
                        <p>លេខកូដយោង៖ <strong>#{{ $order->order_number }}</strong></p>
                    </div>
                </div>

                <!-- Styled QR Frame -->
                <div class="p-4 bg-white rounded-2xl shadow-xl text-center shrink-0">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode('KHQR:HONGCOMPUTER:AMOUNT=' . $order->total_amount . ':BILL=' . $order->order_number) }}"
                         alt="KHQR Code" class="w-44 h-44 mx-auto rounded-lg">
                    <p class="text-[11px] font-bold text-slate-800 mt-2 font-mono">BAKONG / ABA KHQR</p>
                    <p class="text-[10px] text-slate-400">ស្កេនទូទាត់បានគ្រប់ធនាគារ</p>
                </div>
            </div>
        @endif

        <!-- 4. Order Details & Printable Invoice -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6 print:shadow-none print:border-none print:p-0">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="font-bold text-base text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice text-blue-600"></i>
                        <span>ព័ត៌មានលម្អិតនៃវិក្កយបត្រ (Invoice Details)</span>
                    </h3>
                </div>
                <button type="button" onclick="window.print()"
                        class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm print:hidden cursor-pointer">
                    <i class="fa-solid fa-print"></i> បោះពុម្ពវិក្កយបត្រ (Print)
                </button>
            </div>

            <!-- Customer & Shipping Summary Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs bg-slate-50 p-5 rounded-2xl border border-slate-100">
                <div class="space-y-1.5">
                    <p class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">ព័ត៌មានអ្នកទទួល</p>
                    <p class="font-bold text-slate-900 text-sm">{{ $order->customer_name }}</p>
                    <p class="text-slate-600"><i class="fa-solid fa-phone text-[10px] mr-1 text-blue-500"></i> {{ $order->customer_phone }}</p>
                    @if($order->customer_email)
                        <p class="text-slate-600"><i class="fa-solid fa-envelope text-[10px] mr-1 text-rose-500"></i> {{ $order->customer_email }}</p>
                    @endif
                </div>

                <div class="space-y-1.5">
                    <p class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">អាសយដ្ឋានដឹកជញ្ជូន</p>
                    <p class="text-slate-800 font-medium">{{ $order->shipping_address }}</p>
                    <p class="text-slate-500 pt-1">
                        វិធីសាស្ត្រទូទាត់៖ <strong class="text-slate-800 uppercase">{{ $order->payment_method }}</strong>
                    </p>
                </div>
            </div>

            <!-- Items Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 border-b border-slate-100 font-bold uppercase tracking-wider">
                            <th class="p-3">មុខទំនិញ</th>
                            <th class="p-3 text-right">តម្លៃរាយ</th>
                            <th class="p-3 text-center">ចំនួន</th>
                            <th class="p-3 text-right">សរុប</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="p-3 font-semibold text-slate-800">{{ $item->product_name }}</td>
                                <td class="p-3 text-right font-sans">${{ number_format($item->price, 2) }}</td>
                                <td class="p-3 text-center font-bold">{{ $item->quantity }}</td>
                                <td class="p-3 text-right font-bold text-slate-900 font-sans">${{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Financial Summary Breakdown -->
            <div class="border-t border-slate-100 pt-4 flex justify-end">
                <div class="w-full sm:w-64 space-y-2 text-xs text-slate-600">
                    <div class="flex justify-between items-center">
                        <span>តម្លៃទំនិញសរុប</span>
                        <span class="font-bold text-slate-800 font-sans">${{ number_format($order->subtotal, 2) }}</span>
                    </div>

                    @if($order->discount_amount > 0)
                        <div class="flex justify-between items-center text-emerald-600 font-bold">
                            <span>បញ្ចុះតម្លៃពីគូប៉ុង</span>
                            <span class="font-sans">-${{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                    @endif

                    @if($order->tax_amount > 0)
                        <div class="flex justify-between items-center">
                            <span>ពន្ធ</span>
                            <span class="font-semibold font-sans">${{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                    @endif

                    <div class="pt-2 border-t border-slate-100 flex justify-between items-baseline">
                        <span class="text-sm font-bold text-slate-900">សរុបទឹកប្រាក់</span>
                        <span class="text-xl font-extrabold text-red-600 font-sans">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Action Buttons -->
            <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4 print:hidden">
                <a href="{{ route('shop.index') }}"
                   class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition flex items-center gap-2">
                    <i class="fa-solid fa-angle-left text-[10px]"></i> ទិញទំនិញបន្ត (Continue Shopping)
                </a>

                <a href="{{ route('order.track', ['order_number' => $order->order_number, 'phone' => $order->customer_phone]) }}"
                   class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-500/20 transition flex items-center gap-2">
                    <i class="fa-solid fa-route"></i> តាមដានការដឹកជញ្ជូន (Track Order)
                </a>
            </div>
        </div>

    </div>

</x-storefront-layout>

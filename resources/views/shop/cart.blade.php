<x-storefront-layout title="កន្ត្រកទំនិញ (Shopping Cart)">

    <!-- Breadcrumb -->
    {{-- <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <a href="{{ route('shop.index') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                    <i class="fa-solid fa-house text-[10px]"></i> ទំព័រដើម
                </a>
                <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                <span class="text-slate-800 font-bold">កន្ត្រកទំនិញ</span>
            </nav>
        </div>
    </div> --}}

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if(empty($cart))
            <!-- Empty Cart State -->
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-xl mx-auto shadow-sm space-y-5">
                <div class="w-20 h-20 rounded-full bg-blue-50 text-blue-600 mx-auto flex items-center justify-center text-3xl">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                </div>
                <div class="space-y-2">
                    <h2 class="text-xl font-bold text-slate-800">កន្ត្រកទំនិញរបស់អ្នកនៅទទេឡើយ</h2>
                    <p class="text-xs text-slate-400">
                        អ្នកមិនទាន់បានជ្រើសរើសទំនិញណាមួយដាក់ក្នុងកន្ត្រកនៅឡើយទេ។ សូមស្វែងរកកុំព្យូទ័រដែលលោកអ្នកពេញចិត្តឥឡូវនេះ!
                    </p>
                </div>
                <a href="{{ route('shop.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-2xl shadow-lg shadow-blue-500/20 transition">
                    <i class="fa-solid fa-laptop"></i> ស្វែងរកកុំព្យូទ័រក្នុងហាង
                </a>
            </div>
        @else
            <!-- Active Cart Layout -->
            <div class="flex flex-col lg:flex-row gap-8 items-start">

                <!-- Left Column: Items Table & Coupon (8 cols) -->
                <div class="w-full lg:w-8/12 space-y-6">

                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                            <h1 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-cart-shopping text-blue-600"></i>
                                <span>ទំនិញក្នុងកន្ត្រក ({{ count($cart) }} មុខ)</span>
                            </h1>

                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('តើអ្នកប្រាកដជាចង់សម្អាតកន្ត្រកទំនិញទាំងអស់មែនទេ?');">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-rose-600 hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-trash-can text-[11px]"></i> សម្អាតទាំងអស់
                                </button>
                            </form>
                        </div>

                        <!-- Cart Items List -->
                        <div class="divide-y divide-slate-100">
                            @foreach($cart as $item)
                                <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                                    <div class="flex items-center gap-4">
                                        <!-- Image -->
                                        <div class="w-20 h-20 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center p-2 shrink-0 overflow-hidden">
                                            @if($item['image'])
                                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="max-h-full max-w-full object-contain">
                                            @else
                                                <i class="fa-solid fa-laptop text-slate-300 text-2xl"></i>
                                            @endif
                                        </div>

                                        <!-- Title & Meta -->
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2">
                                                @if($item['brand'])
                                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-600">{{ $item['brand'] }}</span>
                                                @endif
                                                <span class="text-[10px] text-blue-600 font-semibold">{{ $item['category'] }}</span>
                                            </div>
                                            <h3 class="text-sm font-bold text-slate-900 leading-tight">
                                                <a href="{{ route('shop.show', $item['product_id']) }}" class="hover:text-blue-600 transition">
                                                    {{ $item['name'] }}
                                                </a>
                                            </h3>
                                            <p class="text-xs font-semibold text-slate-500">
                                                ${{ number_format($item['price'], 2) }} / គ្រឿង
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Quantity Modifier & Subtotal -->
                                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto pt-2 sm:pt-0">
                                        <!-- Stepper Form -->
                                        <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm">
                                            <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                                <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                                <button type="submit" class="w-8 h-8 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 transition">
                                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                                </button>
                                            </form>

                                            <span class="w-10 text-center text-xs font-bold text-slate-900">
                                                {{ $item['quantity'] }}
                                            </span>

                                            <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                                <input type="hidden" name="quantity" value="{{ min($item['max_stock'] ?? 999, $item['quantity'] + 1) }}">
                                                <button type="submit" class="w-8 h-8 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 transition">
                                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Line Total -->
                                        <div class="text-right min-w-[80px]">
                                            <span class="text-sm font-extrabold text-slate-900">
                                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </span>
                                        </div>

                                        <!-- Remove Item -->
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition" title="លុបទំនិញនេះ">
                                                <i class="fa-solid fa-xmark text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Coupon Voucher Box -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-ticket text-amber-500"></i>
                                <span>លេខកូដគូប៉ុងបញ្ចុះតម្លៃ (Coupon Code)</span>
                            </h3>
                            @if($coupon)
                                <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs text-rose-600 font-bold hover:underline">
                                        ដកគូប៉ុងចេញ
                                    </button>
                                </form>
                            @endif
                        </div>

                        @if($coupon)
                            <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-between text-xs">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                                    <div>
                                        <p class="font-bold text-emerald-900 font-mono">{{ $coupon['code'] }}</p>
                                        <p class="text-emerald-700 text-[11px]">
                                            បញ្ចុះតម្លៃបាន: <strong class="font-sans">${{ number_format($discountAmount, 2) }}</strong>
                                        </p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 bg-emerald-600 text-white rounded-lg text-[10px] font-bold">អនុវត្តរួច</span>
                            </div>
                        @else
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="code" placeholder="វាយបញ្ចូលកូដគូប៉ុង (ឧ. WELCOME10)" required
                                       class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono uppercase focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                                <button type="submit"
                                        class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition shadow-sm">
                                    អនុវត្ត (Apply)
                                </button>
                            </form>
                        @endif
                    </div>

                </div>

                <!-- Right Column: Order Summary (4 cols) -->
                <div class="w-full lg:w-4/12 space-y-6 lg:sticky lg:top-24">
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-6">
                        <h2 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-blue-600"></i>
                            <span>សង្ខេបការបញ្ជាទិញ (Summary)</span>
                        </h2>

                        <!-- Amounts Breakdown -->
                        <div class="space-y-3 text-xs text-slate-600">
                            <div class="flex justify-between items-center">
                                <span>តម្លៃទំនិញសរុប (Subtotal)</span>
                                <span class="font-bold text-slate-800 font-sans">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            @if($discountAmount > 0)
                                <div class="flex justify-between items-center text-emerald-600 font-semibold">
                                    <span>បញ្ចុះតម្លៃពីគូប៉ុង (Discount)</span>
                                    <span>-${{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between items-center">
                                <span>ថ្លៃដឹកជញ្ជូន (Estimated Shipping)</span>
                                <span class="font-semibold text-slate-800 font-sans">
                                    @if($shippingFee > 0)
                                        ${{ number_format($shippingFee, 2) }}
                                    @else
                                        <span class="text-emerald-600 font-bold">ឥតគិតថ្លៃ</span>
                                    @endif
                                </span>
                            </div>

                            @if($taxAmount > 0)
                                <div class="flex justify-between items-center">
                                    <span>ពន្ធ (Tax {{ $taxRate }}%)</span>
                                    <span class="font-semibold text-slate-800 font-sans">${{ number_format($taxAmount, 2) }}</span>
                                </div>
                            @endif

                            <div class="pt-3 border-t border-slate-100 flex justify-between items-baseline">
                                <span class="text-sm font-bold text-slate-900">ទឹកប្រាក់សរុប (Total)</span>
                                <span class="text-2xl font-extrabold text-red-600 font-sans">
                                    ${{ number_format($total, 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- Proceed to Checkout Button -->
                        <div class="space-y-3 pt-2">
                            <a href="{{ route('checkout.index') }}"
                               class="w-full py-3.5 px-6 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm transition shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 active:scale-95">
                                <span>បន្តទៅការទូទាត់ប្រាក់</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>

                            <a href="{{ route('shop.index') }}"
                               class="w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl font-semibold text-xs transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-angle-left text-[10px]"></i> ទិញទំនិញបន្ថែម (Continue Shopping)
                            </a>
                        </div>

                        <!-- Trust Features -->
                        <div class="pt-4 border-t border-slate-100 space-y-2 text-[11px] text-slate-500">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-lock text-emerald-500"></i>
                                <span>ការទូទាត់ប្រាក់មានសុវត្ថិភាពខ្ពស់ ១០០%</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-box-check text-blue-500"></i>
                                <span>ទំនិញថ្មីប្រអប់សុទ្ធ ធានាគុណភាពផ្លូវការ</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </div>

</x-storefront-layout>

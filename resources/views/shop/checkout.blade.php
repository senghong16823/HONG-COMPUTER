<x-storefront-layout title="ទូទាត់ប្រាក់ (Checkout)">

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <a href="{{ route('shop.index') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                    <i class="fa-solid fa-house text-[10px]"></i> ទំព័រដើម
                </a>
                <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                <a href="{{ route('cart.index') }}" class="hover:text-blue-600 transition">កន្ត្រកទំនិញ</a>
                <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                <span class="text-slate-800 font-bold">ទូទាត់ប្រាក់</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ paymentMethod: 'cod' }">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="flex flex-col lg:flex-row gap-8 items-start">

                <!-- Left Column: Delivery Info & Payment Methods (7 cols) -->
                <div class="w-full lg:w-7/12 space-y-6">

                    <!-- 1. Customer & Shipping Details -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-bold">1</span>
                                <span>ព័ត៌មានអតិថិជន និងអាសយដ្ឋានដឹកជញ្ជូន</span>
                            </h2>

                            @guest
                                <a href="{{ route('login') }}" class="text-xs font-bold text-blue-600 hover:underline">
                                    មានគណនីហើយ? ចូលគណនី
                                </a>
                            @endguest
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                    ឈ្មោះអ្នកទទួល *
                                </label>
                                <input type="text" name="customer_name" required
                                       value="{{ old('customer_name', $currentUser?->name) }}"
                                       placeholder="ឧ. សុខ ដារ៉ា"
                                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 transition">
                                @error('customer_name')
                                    <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                    លេខទូរស័ព្ទទំនាក់ទំនង *
                                </label>
                                <input type="text" name="customer_phone" required
                                       value="{{ old('customer_phone') }}"
                                       placeholder="ឧ. 012 345 678"
                                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 transition">
                                @error('customer_phone')
                                    <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                អ៊ីមែល (សម្រាប់ទទួលវិក្កយបត្រ)
                            </label>
                            <input type="email" name="customer_email"
                                   value="{{ old('customer_email', $currentUser?->email) }}"
                                   placeholder="ឧ. example@gmail.com"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 transition">
                            @error('customer_email')
                                <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Shipping Address -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                អាសយដ្ឋានដឹកជញ្ជូនលម្អិត *
                            </label>
                            <textarea name="shipping_address" rows="3" required
                                      placeholder="សូមបញ្ជាក់៖ ផ្ទះលេខ, ផ្លូវ, ភូមិ/សង្កាត់, ខណ្ឌ/ស្រុក, រាជធានី/ខេត្ត..."
                                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 transition">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Delivery Notes -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                ចំណាំបន្ថែមសម្រាប់ការដឹកជញ្ជូន (ស្រេចចិត្ត)
                            </label>
                            <input type="text" name="notes" value="{{ old('notes') }}"
                                   placeholder="ឧ. ផ្ញើតាមវីរៈប៊ុនថាំ ឬដឹកដល់ម៉ោង ៣រសៀល..."
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                    </div>

                    <!-- 2. Payment Method Selector -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
                        <div class="border-b border-slate-100 pb-4">
                            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-bold">2</span>
                                <span>ជ្រើសរើសវិធីសាស្ត្រទូទាត់ប្រាក់</span>
                            </h2>
                        </div>

                        <div class="space-y-3">
                            <!-- Option 1: COD -->
                            <label class="flex items-start gap-4 p-4 rounded-2xl border-2 transition cursor-pointer"
                                   :class="paymentMethod === 'cod' ? 'border-blue-600 bg-blue-50/50' : 'border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="payment_method" value="cod"
                                       x-model="paymentMethod"
                                       class="mt-1 w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-hand-holding-dollar text-emerald-600 text-base"></i>
                                        <span class="text-sm font-bold text-slate-900">ទូទាត់សាច់ប្រាក់ពេលដឹកដល់ (Cash on Delivery)</span>
                                    </div>
                                    <p class="text-xs text-slate-500">
                                        ពិនិត្យទំនិញរួច ទើបប្រគល់ប្រាក់ជូនអ្នកដឹកជញ្ជូននៅពេលទំនិញមកដល់។
                                    </p>
                                </div>
                            </label>

                            <!-- Option 2: ABA KHQR -->
                            <label class="flex items-start gap-4 p-4 rounded-2xl border-2 transition cursor-pointer"
                                   :class="paymentMethod === 'aba_khqr' ? 'border-blue-600 bg-blue-50/50' : 'border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="payment_method" value="aba_khqr"
                                       x-model="paymentMethod"
                                       class="mt-1 w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <div class="space-y-1 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-qrcode text-red-600 text-base"></i>
                                            <span class="text-sm font-bold text-slate-900">ស្កេនទូទាត់ KHQR (ABA / Bakong)</span>
                                        </div>
                                        <span class="px-2 py-0.5 rounded bg-red-100 text-red-700 font-bold text-[10px]">លឿន & ងាយស្រួល</span>
                                    </div>
                                    <p class="text-xs text-slate-500">
                                        ស្កេនទូទាត់តាមគ្រប់ App ធនាគារក្នុងប្រទេសកម្ពុជា (ABA, Acleda, Wing, Bakong...) នៅលើទំព័របន្ទាប់។
                                    </p>
                                </div>
                            </label>

                            <!-- Option 3: Card / Bank -->
                            <label class="flex items-start gap-4 p-4 rounded-2xl border-2 transition cursor-pointer"
                                   :class="paymentMethod === 'card' ? 'border-blue-600 bg-blue-50/50' : 'border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="payment_method" value="card"
                                       x-model="paymentMethod"
                                       class="mt-1 w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-credit-card text-blue-600 text-base"></i>
                                        <span class="text-sm font-bold text-slate-900">ផ្ទេរប្រាក់តាមធនាគារ / កាត (Bank Card)</span>
                                    </div>
                                    <p class="text-xs text-slate-500">
                                        ផ្ទេរចូលគណនីធនាគារផ្ទាល់របស់ហាង ឬកាត Visa/Mastercard។
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Sticky Order Review (5 cols) -->
                <div class="w-full lg:w-5/12 space-y-6 lg:sticky lg:top-24">
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-box-archive text-blue-600"></i>
                                <span>ទំនិញត្រូវបញ្ជាទិញ ({{ count($cart) }})</span>
                            </h2>
                            <a href="{{ route('cart.index') }}" class="text-xs font-bold text-blue-600 hover:underline">
                                កែប្រែ
                            </a>
                        </div>

                        <!-- Mini Items List -->
                        <div class="space-y-3 max-h-60 overflow-y-auto pr-1 divide-y divide-slate-100">
                            @foreach($cart as $item)
                                <div class="pt-3 flex items-center justify-between gap-3 text-xs">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0 overflow-hidden p-1">
                                            @if($item['image'])
                                                <img src="{{ asset($item['image']) }}" class="max-h-full max-w-full object-contain">
                                            @else
                                                <i class="fa-solid fa-laptop text-slate-300 text-xs"></i>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-800 truncate">{{ $item['name'] }}</p>
                                            <p class="text-[11px] text-slate-400 font-medium">ចំនួន៖ {{ $item['quantity'] }} គ្រឿង</p>
                                        </div>
                                    </div>
                                    <span class="font-bold text-slate-900 shrink-0 font-sans">
                                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Cost Breakdown -->
                        <div class="space-y-2.5 text-xs text-slate-600 border-t border-slate-100 pt-4">
                            <div class="flex justify-between items-center">
                                <span>តម្លៃទំនិញសរុប (Subtotal)</span>
                                <span class="font-bold text-slate-800 font-sans">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            @if($discountAmount > 0)
                                <div class="flex justify-between items-center text-emerald-600 font-bold">
                                    <span>បញ្ចុះតម្លៃពីគូប៉ុង (Discount)</span>
                                    <span class="font-sans">-${{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between items-center">
                                <span>ថ្លៃដឹកជញ្ជូន (Shipping)</span>
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
                                <span class="text-sm font-bold text-slate-900">ទឹកប្រាក់សរុបត្រូវបង់</span>
                                <span class="text-2xl font-extrabold text-red-600 font-sans">
                                    ${{ number_format($total, 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit"
                                class="w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm transition shadow-xl shadow-blue-500/25 flex items-center justify-center gap-2 active:scale-95 cursor-pointer">
                            <i class="fa-solid fa-lock text-xs"></i>
                            <span>បញ្ជាក់ការបញ្ជាទិញឥឡូវនេះ (Place Order)</span>
                        </button>

                        <div class="text-center text-[11px] text-slate-400">
                            <p>ចុច "បញ្ជាក់ការបញ្ជាទិញ" មានន័យថាអ្នកយល់ព្រមតាមគោលការណ៍របស់ហាង</p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

</x-storefront-layout>

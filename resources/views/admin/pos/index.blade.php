<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
                <i class="fa-solid fa-cash-register text-amber-500"></i>
                {{ __('ប្រព័ន្ធលក់រាយ & POS (Point of Sale)') }}
            </h2>
            <div class="flex items-center gap-3">
                <span class="text-xs bg-emerald-100 text-emerald-800 font-semibold px-3 py-1 rounded-full flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    ស្ថានីយលក់កំពុងដំណើរការ (Online)
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 min-h-[calc(100vh-5rem)] font-['Kantumruy_Pro',sans-serif]" 
         x-data="posSystem({
             products: {{ Js::from($products) }},
             categories: {{ Js::from($categories) }},
             coupons: {{ Js::from($coupons) }},
             taxRate: {{ $taxRate }},
             checkoutUrl: '{{ route('admin.pos.checkout') }}',
             csrfToken: '{{ csrf_token() }}'
         })">
        
        <div class="max-w-[1600px] mx-auto sm:px-4 lg:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- LEFT / CENTER: Products Catalog (Col 7 or 8) -->
                <div class="lg:col-span-7 xl:col-span-8 space-y-4">
                    
                    <!-- Search & Filter Controls -->
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-3 items-center justify-between">
                        <!-- Search Box -->
                        <div class="relative w-full md:w-80">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" x-model="searchQuery" placeholder="ស្វែងរកកុំព្យូទ័រតាមឈ្មោះ ឬ Spec..." 
                                   class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition">
                        </div>

                        <!-- Category Selector Pills -->
                        <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-1 md:pb-0 scrollbar-none">
                            <button @click="selectedCategory = 'all'"
                                    :class="selectedCategory === 'all' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition cursor-pointer">
                                ទាំងអស់ ({{ count($products) }})
                            </button>
                            <template x-for="cat in categories" :key="cat.id">
                                <button @click="selectedCategory = cat.id"
                                        :class="selectedCategory === cat.id ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition cursor-pointer flex items-center gap-1.5">
                                    <i :class="cat.icon ? 'fa-solid ' + cat.icon : 'fa-solid fa-folder'" class="text-[11px]"></i>
                                    <span x-text="cat.name"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                        <template x-for="prod in filteredProducts" :key="prod.id">
                            <div @click="addToCart(prod)"
                                 :class="prod.stock <= 0 ? 'opacity-60 cursor-not-allowed bg-slate-50' : 'cursor-pointer hover:shadow-md hover:-translate-y-0.5 bg-white border-slate-100 hover:border-blue-200'"
                                 class="p-3.5 rounded-2xl border transition-all duration-200 flex flex-col justify-between group relative select-none">
                                
                                <div>
                                    <!-- Image Thumbnail -->
                                    <div class="h-32 w-full rounded-xl bg-slate-50 overflow-hidden flex items-center justify-center mb-2.5 relative border border-slate-100">
                                        <template x-if="prod.image">
                                            <img :src="'/' + prod.image" :alt="prod.name" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </template>
                                        <template x-if="!prod.image">
                                            <i class="fa-solid fa-laptop text-slate-300 text-3xl"></i>
                                        </template>
                                        
                                        <!-- Stock Pill -->
                                        <div class="absolute top-2 right-2">
                                            <span x-show="prod.stock > 0" 
                                                  :class="prod.stock > 3 ? 'bg-emerald-500/90 text-white' : 'bg-amber-500/90 text-white'"
                                                  class="text-[10px] font-bold px-2 py-0.5 rounded-md backdrop-blur-xs">
                                                ស្តុក: <span x-text="prod.stock"></span>
                                            </span>
                                            <span x-show="prod.stock <= 0" class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-rose-500 text-white">
                                                អស់ស្តុក
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Product Info -->
                                    <h4 class="font-bold text-slate-800 text-sm line-clamp-1 group-hover:text-blue-600 transition-colors" x-text="prod.name"></h4>
                                    <p class="text-[11px] text-slate-400 truncate mt-0.5" x-text="prod.cpu ? (prod.cpu + (prod.ram ? ' • ' + prod.ram : '')) : (prod.category ? prod.category.name : 'Computer')"></p>
                                </div>

                                <!-- Price & Action -->
                                <div class="flex items-center justify-between mt-3 pt-2.5 border-t border-slate-100">
                                    <span class="text-base font-bold text-blue-600" x-text="'$' + parseFloat(prod.price).toFixed(2)"></span>
                                    <button type="button" 
                                            :disabled="prod.stock <= 0"
                                            class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors cursor-pointer">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="filteredProducts.length === 0" class="bg-white p-12 text-center rounded-2xl border border-slate-100">
                        <i class="fa-solid fa-magnifying-glass text-4xl text-slate-300 mb-2"></i>
                        <p class="text-slate-500 font-medium">រកមិនឃើញទំនិញដែលត្រូវគ្នានឹងពាក្យស្វែងរកឡើយ</p>
                    </div>

                </div>

                <!-- RIGHT: Cart & Checkout Panel (Col 5 or 4) -->
                <div class="lg:col-span-5 xl:col-span-4 bg-white rounded-2xl border border-slate-100 shadow-sm flex flex-col sticky top-24">
                    
                    <!-- Cart Header -->
                    <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-900 text-white rounded-t-2xl">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-cart-shopping text-amber-400 text-base"></i>
                            <h3 class="font-bold text-base">កន្ត្រកទំនិញ (Cart)</h3>
                            <span class="bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full font-bold" x-text="cartItemCount"></span>
                        </div>
                        <button type="button" @click="clearCart()" x-show="cart.length > 0" 
                                class="text-xs text-rose-300 hover:text-rose-100 cursor-pointer flex items-center gap-1 transition">
                            <i class="fa-solid fa-trash-can"></i> សម្អាត
                        </button>
                    </div>

                    <!-- Customer Input Form -->
                    <div class="p-3.5 border-b border-slate-100 bg-slate-50/50 space-y-2">
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" x-model="customerName" placeholder="ឈ្មោះអតិថិជន (ជាជម្រើស)"
                                   class="px-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg outline-none focus:border-blue-500">
                            <input type="text" x-model="customerPhone" placeholder="លេខទូរស័ព្ទ..."
                                   class="px-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Cart Item List -->
                    <div class="p-3.5 max-h-72 overflow-y-auto space-y-2.5 divide-y divide-slate-100">
                        <template x-for="(item, index) in cart" :key="item.id">
                            <div class="pt-2 flex items-center justify-between gap-2">
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-slate-800 text-xs truncate" x-text="item.name"></p>
                                    <p class="text-[11px] text-blue-600 font-semibold" x-text="'$' + item.price.toFixed(2)"></p>
                                </div>
                                
                                <!-- Quantity Buttons -->
                                <div class="flex items-center gap-1.5 bg-slate-100 px-2 py-1 rounded-lg">
                                    <button type="button" @click="updateQty(item, -1)" class="text-slate-600 hover:text-red-600 font-bold px-1 cursor-pointer">−</button>
                                    <span class="text-xs font-bold w-5 text-center" x-text="item.quantity"></span>
                                    <button type="button" @click="updateQty(item, 1)" class="text-slate-600 hover:text-green-600 font-bold px-1 cursor-pointer">+</button>
                                </div>

                                <!-- Item Total & Delete -->
                                <div class="text-right">
                                    <p class="font-bold text-slate-900 text-xs" x-text="'$' + (item.price * item.quantity).toFixed(2)"></p>
                                    <button type="button" @click="removeItem(index)" class="text-slate-400 hover:text-rose-500 text-[10px] cursor-pointer">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <div x-show="cart.length === 0" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-cart-arrow-down text-3xl text-slate-300 mb-2"></i>
                            <p class="text-xs font-medium">កន្ត្រកទទេស្អាត! សូមចុចលើទំនិញដើម្បីបញ្ចូល</p>
                        </div>
                    </div>

                    <!-- Discount & Totals -->
                    <div class="p-4 border-t border-slate-100 bg-slate-50 space-y-3">
                        
                        <!-- Coupon / Promo code -->
                        <div class="flex gap-2">
                            <select x-model="selectedCouponCode" @change="applyCoupon()" class="text-xs py-1.5 px-3 bg-white border border-slate-200 rounded-lg flex-1 outline-none">
                                <option value="">-- ជ្រើសរើសគូប៉ុងបញ្ចុះតម្លៃ --</option>
                                <template x-for="c in coupons" :key="c.id">
                                    <option :value="c.code" x-text="c.code + ' (' + (c.type === 'percent' ? c.value + '%' : '$' + c.value) + ' off)'"></option>
                                </template>
                            </select>
                            <button type="button" @click="removeCoupon()" x-show="discountAmount > 0" class="px-2.5 py-1.5 bg-rose-100 text-rose-700 text-xs rounded-lg hover:bg-rose-200 cursor-pointer">
                                ដកចេញ
                            </button>
                        </div>

                        <!-- Calculations -->
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span>តម្លៃទំនិញសរុប (Subtotal)</span>
                                <span class="font-semibold text-slate-800" x-text="'$' + subtotal.toFixed(2)"></span>
                            </div>
                            <div class="flex justify-between text-emerald-600" x-show="discountAmount > 0">
                                <span>បញ្ចុះតម្លៃ (Discount)</span>
                                <span class="font-semibold" x-text="'-$' + discountAmount.toFixed(2)"></span>
                            </div>
                            <div class="flex justify-between" x-show="taxAmount > 0">
                                <span>ពន្ធ (Tax <span x-text="taxRate"></span>%)</span>
                                <span class="font-semibold text-slate-800" x-text="'$' + taxAmount.toFixed(2)"></span>
                            </div>
                            <div class="flex justify-between text-base font-bold text-slate-900 pt-2 border-t border-slate-200">
                                <span>សរុបចុងក្រោយ (Total)</span>
                                <span class="text-blue-600 text-xl" x-text="'$' + grandTotal.toFixed(2)"></span>
                            </div>
                        </div>

                        <!-- Payment Method Selector -->
                        <div class="pt-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">វិធីសាស្ត្រទូទាត់ប្រាក់</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button type="button" @click="paymentMethod = 'cash'"
                                        :class="paymentMethod === 'cash' ? 'border-blue-600 bg-blue-50 text-blue-700 font-bold' : 'border-slate-200 bg-white text-slate-600'"
                                        class="py-2 px-2 text-xs rounded-xl border flex flex-col items-center gap-1 transition cursor-pointer">
                                    <i class="fa-solid fa-money-bill-wave text-base"></i>
                                    <span>សាច់ប្រាក់</span>
                                </button>
                                <button type="button" @click="paymentMethod = 'aba_khqr'"
                                        :class="paymentMethod === 'aba_khqr' ? 'border-blue-600 bg-blue-50 text-blue-700 font-bold' : 'border-slate-200 bg-white text-slate-600'"
                                        class="py-2 px-2 text-xs rounded-xl border flex flex-col items-center gap-1 transition cursor-pointer">
                                    <i class="fa-solid fa-qrcode text-base"></i>
                                    <span>ABA KHQR</span>
                                </button>
                                <button type="button" @click="paymentMethod = 'card'"
                                        :class="paymentMethod === 'card' ? 'border-blue-600 bg-blue-50 text-blue-700 font-bold' : 'border-slate-200 bg-white text-slate-600'"
                                        class="py-2 px-2 text-xs rounded-xl border flex flex-col items-center gap-1 transition cursor-pointer">
                                    <i class="fa-solid fa-credit-card text-base"></i>
                                    <span>កាតធនាគារ</span>
                                </button>
                            </div>
                        </div>

                        <!-- Cash Received & Change (If Cash selected) -->
                        <div x-show="paymentMethod === 'cash'" class="p-3 bg-white rounded-xl border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-slate-600">ប្រាក់ទទួលពីភ្ញៀវ ($):</span>
                                <input type="number" step="0.01" x-model.number="cashReceived" placeholder="0.00"
                                       class="w-28 text-right font-bold py-1 px-2 border border-slate-300 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-100">
                                <span class="font-medium text-slate-600">ប្រាក់អាប់ជូន ($):</span>
                                <span class="font-bold text-sm" :class="changeAmount >= 0 ? 'text-emerald-600' : 'text-rose-500'" 
                                      x-text="'$' + (changeAmount >= 0 ? changeAmount.toFixed(2) : '0.00')"></span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <button type="button" 
                                @click="processCheckout()" 
                                :disabled="cart.length === 0 || isProcessing"
                                :class="cart.length === 0 || isProcessing ? 'bg-slate-300 cursor-not-allowed' : 'bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 shadow-md shadow-emerald-500/20 cursor-pointer'"
                                class="w-full py-3 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition duration-200">
                            <i class="fa-solid fa-circle-check" x-show="!isProcessing"></i>
                            <i class="fa-solid fa-spinner animate-spin" x-show="isProcessing"></i>
                            <span x-text="isProcessing ? 'កំពុងដំណើរការ...' : 'គិតលុយ & បោះពុម្ពវិក្កយបត្រ'"></span>
                        </button>

                    </div>

                </div>

            </div>
        </div>

        <!-- Receipt Modal -->
        <div x-show="receiptModalOpen" style="display: none;" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl space-y-4 border border-slate-100 animate-in fade-in zoom-in duration-150">
                
                <!-- Receipt Header -->
                <div class="text-center border-b border-slate-200 pb-3">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-2 text-2xl">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg">HONG COMPUTER</h3>
                    <p class="text-xs text-slate-500">វិក្កយបត្រលក់រាយ (Receipt)</p>
                    <p class="text-[11px] text-slate-400 mt-1" x-text="'លេខកូដ៖ #' + (completedOrder.order_number || '')"></p>
                    <p class="text-[11px] text-slate-400" x-text="'កាលបរិច្ឆេទ៖ ' + (completedOrder.date || '')"></p>
                </div>

                <!-- Items list -->
                <div class="space-y-1.5 text-xs max-h-48 overflow-y-auto divide-y divide-slate-100">
                    <template x-for="item in completedOrderItems" :key="item.id">
                        <div class="pt-1.5 flex justify-between">
                            <span class="text-slate-700 truncate max-w-[180px]" x-text="item.name + ' x' + item.quantity"></span>
                            <span class="font-bold text-slate-900" x-text="'$' + (item.price * item.quantity).toFixed(2)"></span>
                        </div>
                    </template>
                </div>

                <!-- Receipt Total -->
                <div class="border-t border-slate-200 pt-2 space-y-1 text-xs">
                    <div class="flex justify-between text-base font-bold text-slate-900 pt-1">
                        <span>សរុបត្រូវបង់៖</span>
                        <span class="text-emerald-600 text-lg" x-text="'$' + (completedOrder.total_amount || '0.00')"></span>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex gap-2 pt-2">
                    <button type="button" @click="window.print()" class="flex-1 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold flex items-center justify-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-print"></i> បោះពុម្ព
                    </button>
                    <button type="button" @click="receiptModalOpen = false" class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold cursor-pointer">
                        បិទ
                    </button>
                </div>

            </div>
        </div>

    </div>

    <!-- Alpine POS Logic -->
    <script>
        function posSystem(config) {
            return {
                products: config.products || [],
                categories: config.categories || [],
                coupons: config.coupons || [],
                taxRate: config.taxRate || 0,
                checkoutUrl: config.checkoutUrl,
                csrfToken: config.csrfToken,

                searchQuery: '',
                selectedCategory: 'all',
                cart: [],
                customerName: '',
                customerPhone: '',
                selectedCouponCode: '',
                appliedCoupon: null,
                paymentMethod: 'cash',
                cashReceived: null,
                isProcessing: false,
                receiptModalOpen: false,
                completedOrder: {},
                completedOrderItems: [],

                get filteredProducts() {
                    return this.products.filter(p => {
                        const matchCat = this.selectedCategory === 'all' || p.category_id == this.selectedCategory;
                        const matchSearch = !this.searchQuery || 
                            p.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            (p.cpu && p.cpu.toLowerCase().includes(this.searchQuery.toLowerCase()));
                        return matchCat && matchSearch;
                    });
                },

                get cartItemCount() {
                    return this.cart.reduce((sum, item) => sum + item.quantity, 0);
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                get discountAmount() {
                    if (!this.appliedCoupon) return 0;
                    if (this.appliedCoupon.type === 'percent') {
                        let disc = (this.subtotal * parseFloat(this.appliedCoupon.value)) / 100;
                        if (this.appliedCoupon.max_discount_amount && disc > parseFloat(this.appliedCoupon.max_discount_amount)) {
                            disc = parseFloat(this.appliedCoupon.max_discount_amount);
                        }
                        return disc;
                    }
                    return Math.min(parseFloat(this.appliedCoupon.value), this.subtotal);
                },

                get taxAmount() {
                    const taxable = Math.max(0, this.subtotal - this.discountAmount);
                    return (taxable * this.taxRate) / 100;
                },

                get grandTotal() {
                    return Math.max(0, this.subtotal - this.discountAmount + this.taxAmount);
                },

                get changeAmount() {
                    if (!this.cashReceived) return 0;
                    return this.cashReceived - this.grandTotal;
                },

                addToCart(prod) {
                    if (prod.stock <= 0) return;
                    const existing = this.cart.find(i => i.id === prod.id);
                    if (existing) {
                        if (existing.quantity < prod.stock) {
                            existing.quantity++;
                        } else {
                            alert('ចំនួនក្នុងស្តុកមិនគ្រប់គ្រាន់!');
                        }
                    } else {
                        this.cart.push({
                            id: prod.id,
                            name: prod.name,
                            price: parseFloat(prod.price),
                            quantity: 1,
                            stock: prod.stock
                        });
                    }
                },

                updateQty(item, delta) {
                    const newQty = item.quantity + delta;
                    if (newQty <= 0) {
                        this.cart = this.cart.filter(i => i.id !== item.id);
                    } else if (newQty <= item.stock) {
                        item.quantity = newQty;
                    } else {
                        alert('ចំនួនក្នុងស្តុកមិនគ្រប់គ្រាន់!');
                    }
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                },

                clearCart() {
                    if (confirm('តើអ្នកពិតជាចង់សម្អាតកន្ត្រកទំនិញមែនទេ?')) {
                        this.cart = [];
                        this.appliedCoupon = null;
                        this.selectedCouponCode = '';
                    }
                },

                applyCoupon() {
                    if (!this.selectedCouponCode) {
                        this.appliedCoupon = null;
                        return;
                    }
                    const coupon = this.coupons.find(c => c.code === this.selectedCouponCode);
                    if (coupon) {
                        if (coupon.min_order_amount && this.subtotal < parseFloat(coupon.min_order_amount)) {
                            alert('គូប៉ុងនេះទាមទារការទិញយ៉ាងតិច $' + coupon.min_order_amount);
                            this.selectedCouponCode = '';
                            this.appliedCoupon = null;
                            return;
                        }
                        this.appliedCoupon = coupon;
                    }
                },

                removeCoupon() {
                    this.appliedCoupon = null;
                    this.selectedCouponCode = '';
                },

                async processCheckout() {
                    if (this.cart.length === 0) return;
                    if (this.paymentMethod === 'cash' && this.cashReceived && this.cashReceived < this.grandTotal) {
                        alert('ប្រាក់ទទួលពីភ្ញៀវមិនគ្រប់គ្រាន់សម្រាប់ការទូទាត់ឡើយ!');
                        return;
                    }

                    this.isProcessing = true;

                    const payload = {
                        customer_name: this.customerName || 'អតិថិជនទូទៅ (Walk-in)',
                        customer_phone: this.customerPhone || null,
                        payment_method: this.paymentMethod,
                        subtotal: this.subtotal,
                        discount_amount: this.discountAmount,
                        tax_amount: this.taxAmount,
                        total_amount: this.grandTotal,
                        items: this.cart.map(i => ({
                            product_id: i.id,
                            name: i.name,
                            price: i.price,
                            quantity: i.quantity
                        }))
                    };

                    try {
                        const response = await fetch(this.checkoutUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.completedOrder = data;
                            this.completedOrderItems = [...this.cart];
                            this.receiptModalOpen = true;

                            // Deduct locally from product list
                            this.cart.forEach(cartItem => {
                                const prod = this.products.find(p => p.id === cartItem.id);
                                if (prod) prod.stock -= cartItem.quantity;
                            });

                            // Reset cart
                            this.cart = [];
                            this.customerName = '';
                            this.customerPhone = '';
                            this.appliedCoupon = null;
                            this.selectedCouponCode = '';
                            this.cashReceived = null;
                        } else {
                            alert(data.message || 'មានបញ្ហាក្នុងការគិតលុយ!');
                        }
                    } catch (e) {
                        alert('មានកំហុសបណ្តាញ សូមព្យាយាមម្តងទៀត!');
                    } finally {
                        this.isProcessing = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>

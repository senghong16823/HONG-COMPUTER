<footer class="bg-slate-900 text-slate-300 border-t border-slate-800 mt-auto font-['Kantumruy_Pro',sans-serif]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- 1. Store Brand & About -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-lg font-bold shadow-md shadow-blue-500/20">
                        <i class="fa-solid fa-laptop text-white"></i>
                    </div>
                    <div>
                        <span class="text-lg font-extrabold text-white tracking-tight">
                            {{ \App\Models\Setting::get('store_name', 'HONG COMPUTER') }}
                        </span>
                        <p class="text-[10px] text-slate-400 font-medium tracking-wide uppercase">Computer & Electronics
                        </p>
                    </div>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">
                    មជ្ឈមណ្ឌលផ្គត់ផ្គង់កុំព្យូទ័រ Laptop, Desktop, គ្រឿងបន្លាស់ Gaming និងសម្ភារៈការិយាល័យគុណភាពខ្ពស់
                    ជាមួយតម្លៃសមរម្យ និងការធានាផ្លូវការ។
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ \App\Models\Setting::get('facebook_page', 'https://facebook.com') }}" target="_blank"
                        class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-400 hover:text-white flex items-center justify-center text-sm transition">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://t.me/SENGHONG_SH" target="_blank"
                        class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-sky-500 text-slate-400 hover:text-white flex items-center justify-center text-sm transition">
                        <i class="fa-brands fa-telegram"></i>
                    </a>
                </div>
            </div>

            <!-- 2. Categories Quick Links -->
            <div>
                <h4 class="text-white text-sm font-bold tracking-wider uppercase mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-blue-500 text-xs"></i> ប្រភេទកុំព្យូទ័រ
                </h4>
                <ul class="space-y-2.5 text-base text-slate-400">
                    @forelse(\App\Models\Category::take(6)->get() as $footCat)
                        <li>
                            <a href="{{ route('shop.index', ['category_id' => $footCat->id]) }}"
                                class="hover:text-white transition flex items-center gap-1.5">
                                <i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i> {{ $footCat->name }}
                            </a>
                        </li>
                    @empty
                        <li><a href="{{ route('shop.index') }}" class="hover:text-white transition">ទំនិញទាំងអស់</a></li>
                    @endforelse
                </ul>
            </div>

            <!-- 3. Customer Service & Information -->
            <div>
                <h4 class="text-white text-sm font-bold tracking-wider uppercase mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-amber-500 text-xs"></i> សេវាកម្ម & ជំនួយ
                </h4>
                <ul class="space-y-2.5 text-ms text-slate-400">
                    <li>
                        <a href="{{ route('order.track') }}"
                            class="hover:text-white transition flex items-center gap-1.5">
                            <i class="fa-solid fa-route text-[15px] text-slate-600"></i> តាមដានការបញ្ជាទិញ (Track Order)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}"
                            class="hover:text-white transition flex items-center gap-1.5">
                            <i class="fa-solid fa-cart-shopping text-[15px] text-slate-600"></i> កន្ត្រកទំនិញ (Cart)
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('customer.orders') }}"
                                class="hover:text-white transition flex items-center gap-1.5">
                                <i class="fa-solid fa-box-archive text-[15px] text-slate-600"></i> ការបញ្ជាទិញរបស់ខ្ញុំ (My
                                Orders)
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="hover:text-white transition flex items-center gap-1.5">
                                <i class="fa-solid fa-user text-[15px] text-slate-600"></i> ចូលគណនី (Login)
                            </a>
                        </li>
                    @endauth
                    <li>
                        <a href="" class="text-slate-500 flex items-center gap-1.5 hover:text-white transition">
                            <i class="fa-solid fa-certificate text-[15px]"></i> ការធានា និងប្តូរទំនិញ
                        </a>
                    </li>
                </ul>
            </div>

            <!-- 4. Contacts & Payment Badges -->
            <div class="space-y-4">
                <h4 class="text-white text-sm font-bold tracking-wider uppercase flex items-center gap-2">
                    <i class="fa-solid fa-headset text-emerald-500 text-xs"></i> ទំនាក់ទំនងហាង
                </h4>
                <ul class="space-y-2.5 text-xs text-slate-400">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-location-dot text-amber-400 mt-0.5"></i>
                        <span>{{ \App\Models\Setting::get('store_address', 'ផ្លូវ 271, រាជធានីភ្នំពេញ, ប្រទេសកម្ពុជា') }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-blue-400"></i>
                        <span
                            class="text-white font-semibold">{{ \App\Models\Setting::get('store_phone', '093 757 079 / 097 422 2126') }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-rose-400"></i>
                        <span>{{ \App\Models\Setting::get('store_email', 'chanthasenghong.com') }}</span>
                    </li>
                </ul>

                <!-- Payment Methods -->
                <div class="pt-2">
                    <p class="text-[11px] text-slate-400 font-semibold mb-2">ជម្រើសទូទាត់ប្រាក់៖</p>
                    <div class="flex items-center gap-2 flex-wrap text-xs">
                        <span
                            class="px-2 py-1 bg-slate-800 text-white rounded font-bold border border-slate-700">KHQR</span>
                        <span
                            class="px-2 py-1 bg-slate-800 text-white rounded font-bold border border-slate-700">ABA</span>
                        <span class="px-2 py-1 bg-slate-800 text-white rounded font-bold border border-slate-700">Cash
                            on Delivery</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="bg-slate-950 border-t border-slate-800/80 py-4 px-4 text-center">
        <p class="text-xs text-slate-400">
            &copy; {{ date('Y') }} <span
                class="text-white font-semibold">{{ \App\Models\Setting::get('store_name', 'HONG COMPUTER') }}</span>.
            រក្សាសិទ្ធិគ្រប់យ៉ាង។
        </p>
    </div>
</footer>
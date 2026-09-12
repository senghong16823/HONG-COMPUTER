<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? \App\Models\Setting::get('store_name', 'HONG COMPUTER') }} - ហាងលក់កុំព្យូទ័រ និងសម្ភារៈអេឡិចត្រូនិក</title>

    <!-- Google Font: Kantumruy Pro & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Kantumruy Pro', 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen selection:bg-blue-600 selection:text-white"
      x-data="cartStore()" x-init="initCart()">

    <!-- 1. Top Announcement Bar -->
    <header class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5 text-amber-400 font-medium">
                    <i class="fa-solid fa-truck-fast"></i> សេវាដឹកជញ្ជូនរហ័សទូទាំង ២៥ ខេត្ត-ក្រុង
                </span>
                <span class="hidden md:inline text-slate-600">|</span>
                <span class="hidden md:flex items-center gap-1.5 hover:text-white transition">
                    <i class="fa-solid fa-phone text-blue-400"></i> {{ \App\Models\Setting::get('store_phone', '093 757 079 / 097 422 21 26') }}
                </span>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <a href="{{ route('order.track') }}" class="flex items-center gap-1 hover:text-amber-400 transition font-medium">
                    <i class="fa-solid fa-route"></i> តាមដានការបញ្ជាទិញ (Track Order)
                </a>
                <span class="text-slate-600">|</span>
                <a href="https://t.me/SENGHONG_SH" target="_blank" class="flex items-center gap-1 hover:text-sky-400 transition">
                    <i class="fa-brands fa-telegram text-sky-400"></i> Telegram
                </a>
            </div>
        </div>
    </header>

    <!-- 2. Main Navigation Header -->
    <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-md shadow-sm border-b border-slate-200 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">

                <!-- Brand Logo -->
                <a href="{{ route('shop.index') }}" class="flex items-center gap-3 shrink-0 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-xl font-bold shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                        <i class="fa-solid fa-laptop text-white"></i>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900 group-hover:text-blue-600 transition">
                            {{ \App\Models\Setting::get('store_name', 'HONG COMPUTER') }}
                        </span>
                        <p class="text-[11px] text-slate-400 font-medium tracking-wide uppercase">Computer & Electronics</p>
                    </div>
                </a>

                <!-- Live Search Bar -->
                <div class="flex-1 max-w-xl mx-4 hidden md:block">
                    <form action="{{ route('shop.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="ស្វែងរកកុំព្យូទ័រ..."
                               class="w-full pl-11 pr-24 py-2.5 bg-slate-100/80 hover:bg-slate-100 focus:bg-white border border-slate-200 rounded-full text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-inner">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <button type="submit" class="absolute inset-y-1 right-1 px-4 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-full transition shadow-sm flex items-center gap-1.5">
                            <span>ស្វែងរក</span>
                        </button>
                    </form>
                </div>

                <!-- Right Action Buttons (Account & Cart) -->
                <div class="flex items-center gap-3 shrink-0">

                    <!-- Mobile Search Trigger Button -->
                    <a href="{{ route('shop.index') }}" class="md:hidden w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 transition">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>

                    <!-- Account Dropdown -->
                    @auth
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center gap-2 py-1.5 px-3 rounded-xl hover:bg-slate-100 border border-slate-200 transition">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 font-bold text-xs flex items-center justify-center">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="hidden sm:block text-left text-xs">
                                    <p class="font-bold text-slate-800 truncate max-w-[100px]">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ auth()->user()->is_admin ? 'Admin' : 'អតិថិជន' }}</p>
                                </div>
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition" :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 divide-y divide-slate-100">
                                <div class="px-4 py-2 text-xs">
                                    <p class="text-slate-400">បានចូលប្រើជា</p>
                                    <p class="font-bold text-slate-900 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <div class="py-1">
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-blue-600 hover:bg-blue-50 transition">
                                            <i class="fa-solid fa-gauge-high"></i> ផ្ទាំងគ្រប់គ្រង (Admin Panel)
                                        </a>
                                        <a href="{{ route('admin.pos.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-emerald-600 hover:bg-emerald-50 transition">
                                            <i class="fa-solid fa-cash-register"></i> លក់រាយ POS Terminal
                                        </a>
                                    @endif

                                    <a href="{{ route('customer.orders') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-solid fa-box-archive text-amber-500"></i> ការបញ្ជាទិញរបស់ខ្ញុំ (My Orders)
                                    </a>

                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-solid fa-user-gear text-slate-400"></i> កែប្រែព័ត៌មាន (Profile)
                                    </a>
                                </div>

                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-red-600 hover:bg-red-50 transition">
                                            <i class="fa-solid fa-right-from-bracket"></i> ចាកចេញ (Logout)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-3.5 py-2 text-xs font-bold bg-green-700 rounded-full text-white hover:bg-green-600 shadow-green-500/20 shadow-sm transition">
                                ចូលគណនី
                            </a>
                            <a href="{{ route('register') }}" class="hidden sm:inline-flex px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded-full transition shadow-red-500/20 shadow-sm">
                                ចុះឈ្មោះ
                            </a>
                        </div>
                    @endauth

                    <!-- Shopping Cart Button -->
                    <a href="{{ route('cart.index') }}"
                       class="relative flex items-center gap-2 px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow-md shadow-blue-500/20 transition group">
                        <i class="fa-solid fa-cart-shopping text-base group-hover:scale-110 transition"></i>
                        <span class="hidden sm:inline text-xs font-bold">កន្ត្រក</span>
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-amber-400 text-slate-950 font-extrabold text-[11px] shadow-sm"
                              x-text="cartCount">
                            {{ array_sum(array_column(session('cart', []), 'quantity')) }}
                        </span>
                    </a>

                </div>

            </div>
        </div>

        <!-- Secondary Categories Bar -->
        <div class="bg-slate-50 border-t border-slate-100 hidden sm:block">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between overflow-x-auto py-2 text-xs font-medium text-slate-600 gap-6">
                <div class="flex items-center gap-5">
                    <a href="{{ route('shop.index') }}" class="hover:text-blue-600 transition flex items-center gap-1.5 {{ !request('category_id') && !request('brand_id') ? 'text-blue-600 font-bold' : '' }}">
                        <i class="fa-solid fa-border-all"></i> ទំនិញទាំងអស់
                    </a>

                    <!-- Top Categories Links -->
                    @foreach(\App\Models\Category::take(5)->get() as $navCat)
                        <a href="{{ route('shop.index', ['category_id' => $navCat->id]) }}"
                           class="hover:text-blue-600 transition {{ request('category_id') == $navCat->id ? 'text-blue-600 font-bold' : '' }}">
                            {{ $navCat->name }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-4 shrink-0 text-slate-500">
                    <span class="flex items-center gap-1 text-emerald-600 font-semibold">
                        <i class="fa-solid fa-shield-halved"></i> ធានាគុណភាព ១០០%
                    </span>
                    <span class="flex items-center gap-1 text-blue-600 font-semibold">
                        <i class="fa-solid fa-qrcode"></i> ទូទាត់ KHQR រហ័ស
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <!-- 3. Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl shadow-sm flex items-center justify-between"
                 x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-2xl shadow-sm flex items-center justify-between"
                 x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                    <p class="text-sm font-semibold text-rose-800">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- 4. Main Page Body -->
    <main class="flex-grow">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- 5. Toast Notification for Live Cart Actions -->
    <div x-show="toast.visible"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-4"
         x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-6 right-6 z-50 max-w-sm w-full bg-slate-900 text-white p-4 rounded-2xl shadow-2xl border border-slate-700 flex items-center justify-between gap-4"
         style="display: none;">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                <i class="fa-solid fa-check text-sm font-bold"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-white" x-text="toast.message"></p>
                <a href="{{ route('cart.index') }}" class="text-[11px] text-amber-400 hover:underline font-semibold flex items-center gap-1 mt-0.5">
                    មើលកន្ត្រកទំនិញ <i class="fa-solid fa-arrow-right text-[9px]"></i>
                </a>
            </div>
        </div>
        <button @click="toast.visible = false" class="text-slate-400 hover:text-white">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>

    <!-- 6. Footer -->
    @include('layouts.footer')

    <!-- Alpine.js Store Script for Cart Interaction -->
    <script>
        function cartStore() {
            return {
                cartCount: {{ array_sum(array_column(session('cart', []), 'quantity')) }},
                toast: {
                    visible: false,
                    message: '',
                },
                initCart() {
                    // Ready
                },
                async addToCart(productId, quantity = 1) {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const res = await fetch("{{ route('cart.add') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({ product_id: productId, quantity: quantity })
                        });

                        const data = await res.json();
                        if (data.success) {
                            this.cartCount = data.cart_count;
                            this.showToast(data.message);
                        } else {
                            alert(data.message || 'មិនអាចបន្ថែមចូលកន្ត្រកបានទេ!');
                        }
                    } catch (err) {
                        console.error(err);
                        window.location.href = "{{ url('/product') }}/" + productId;
                    }
                },
                showToast(msg) {
                    this.toast.message = msg;
                    this.toast.visible = true;
                    setTimeout(() => {
                        this.toast.visible = false;
                    }, 4000);
                }
            }
        }
    </script>

</body>

</html>

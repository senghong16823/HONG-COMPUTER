<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- FontAwesome & Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>



<body class="font-['Kantumruy_Pro',sans-serif] antialiased bg-slate-50 text-slate-800">
    <div class="flex min-h-screen">

        <!-- SIDEBAR MENU (Left) -->
        <aside
            class="w-64 bg-slate-900 flex flex-col shrink-0 fixed h-full z-20 transition-all duration-300 border-r border-slate-800">
        
            <!-- App Logo & Brand -->
            <div class="p-4 flex items-center space-x-3 border-b border-slate-800">
                <div
                    class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-sm">
                    <i class="fa-solid fa-store text-amber-500"></i>
                </div>
                <div>
                    <h2 class="font-bold text-white text-sm">HONG <span
                            class="text-[10px] bg-amber-500 text-black px-1.5 py-0.5 rounded font-bold">STORE</span></h2>
                    <p class="text-[10px] text-slate-400">E-Commerce Platform</p>
                </div>
            </div>
        
            <!-- Navigation Links -->
            <nav class="flex-1 px-3 py-4 space-y-6 text-sm overflow-y-auto">
        
                <!-- ផ្នែកទី១៖ ទូទៅ (MAIN) -->
                <div>
                    <p class="text-[10px] uppercase text-slate-500 px-3 pb-2 font-bold tracking-wider">ទូទៅ (MAIN)</p>
                    <div class="space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="group flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-chart-pie w-5 text-center transition-transform group-hover:scale-110"></i>
                            <span>ទិដ្ឋភាពទូទៅ (Dashboard)</span>
                        </a>
        
                        <!-- POS -->
                        <a href="#"
                            class="group flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                            <i class="fa-solid fa-cash-register w-5 text-center transition-transform group-hover:scale-110"></i>
                            <span>លក់រាយ & POS</span>
                        </a>
                    </div>
                </div>
        
                <!-- ផ្នែកទី២៖ ហាង (E-COMMERCE) -->
                <div>
                    <p class="text-[10px] uppercase text-slate-500 px-3 pb-2 font-bold tracking-wider">គ្រប់គ្រងហាង (STORE)</p>
                    <div class="space-y-1">
        
                        <!-- Orders -->
                        <a href="#"
                            class="group flex items-center justify-between px-3 py-2.5 rounded-lg font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <i
                                    class="fa-solid fa-bag-shopping w-5 text-center transition-transform group-hover:scale-110"></i>
                                <span>ការបញ្ជាទិញ (Orders)</span>
                            </div>
                            <!-- Badge សម្គាល់មាន Order ថ្មី -->
                            <span class="bg-amber-500 text-black text-[10px] font-bold px-2 py-0.5 rounded-full">5</span>
                        </a>
        
                        <!-- Products (Dropdown Menu with Alpine.js) -->
                        <div x-data="{ open: {{ request()->routeIs('products.*', 'categories.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open"
                                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200 focus:outline-none">
                                <div class="flex items-center space-x-3">
                                    <i class="fa-solid fa-box-open w-5 text-center"></i>
                                    <span>ផលិតផល (Products)</span>
                                </div>
                                <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            <!-- Sub-menu Items -->
                            <div x-show="open" style="display: none;" class="pl-11 pr-3 py-1 space-y-1 mt-1 border-l-2 border-slate-800 ml-4">
                                <!-- ទី១៖ ភ្ជាប់ទៅកាន់ ProductController -->
                                <a href="{{ route('products.index') }}"
                                    class="block px-3 py-2 text-[13px] rounded-lg transition-colors {{ request()->routeIs('products.*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                                    បញ្ជីទំនិញ
                                </a>
                                
                                <!-- ទី២៖ ភ្ជាប់ទៅកាន់ CategoryController -->
                                <a href="{{ route('categories.index') }}"
                                    class="block px-3 py-2 text-[13px] rounded-lg transition-colors {{ request()->routeIs('categories.*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                                    ប្រភេទ (Categories)
                                </a>
                                
                                <!-- ទី៣៖ ភ្ជាប់ទៅកាន់ BrandController (ឬ # បើមិនទាន់មាន Route) -->
                                <a href="{{ Route::has('brands.index') ? route('brands.index') : '#' }}"
                                    class="block px-3 py-2 text-[13px] rounded-lg transition-colors {{ request()->routeIs('brands.*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                                    ម៉ាក (Brands)
                                </a>
                            </div>
                        </div>
        
                        <!-- Customers -->
                        <a href="#"
                            class="group flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                            <i class="fa-solid fa-users w-5 text-center transition-transform group-hover:scale-110"></i>
                            <span>អតិថិជន (Customers)</span>
                        </a>
        
                        <!-- Promotions / Coupons -->
                        <a href="#"
                            class="group flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                            <i class="fa-solid fa-ticket w-5 text-center transition-transform group-hover:scale-110"></i>
                            <span>ប្រូម៉ូសិន & គូប៉ុង</span>
                        </a>
                    </div>
                </div>
        
                <!-- ផ្នែកទី៣៖ ប្រព័ន្ធ (SYSTEM) -->
                <div>
                    <p class="text-[10px] uppercase text-slate-500 px-3 pb-2 font-bold tracking-wider">ប្រព័ន្ធ (SYSTEM)</p>
                    <div class="space-y-1">
                        <!-- Analytics / Reports -->
                        <a href="#"
                            class="group flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                            <i
                                class="fa-solid fa-file-invoice-dollar w-5 text-center transition-transform group-hover:scale-110"></i>
                            <span>របាយការណ៍ (Reports)</span>
                        </a>
        
                        <!-- Storefront / CMS -->
                        <a href="{{ route('shop.index') }}" target="_blank"
                            class="group flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                            <i class="fa-solid fa-desktop w-5 text-center transition-transform group-hover:scale-110"></i>
                            <span>គេហទំព័រ (Storefront)</span>
                        </a>
        
                        <!-- Settings -->
                        <a href="#"
                            class="group flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                            <i class="fa-solid fa-gear w-5 text-center transition-transform group-hover:scale-110"></i>
                            <span>ការកំណត់ (Settings)</span>
                        </a>
                    </div>
                </div>
        
            </nav>
        
            <!-- Profile & Logout (បាតខាងក្រោម) -->
            <div class="p-4 border-t border-slate-800 flex items-center justify-between bg-slate-900/50">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-9 h-9 bg-slate-800 text-white font-bold rounded-full flex items-center justify-center text-sm border border-slate-700">
                        {{ mb_substr(Auth::user()?->name ?? 'H', 0, 1, 'UTF-8') }}
                    </div>
                    <div class="truncate w-24">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()?->name ?? 'Mr. Hong' }}</p>
                        <p class="text-[10px] text-slate-400">{{ Auth::user()?->is_admin ? 'Super Admin' : 'User' }}</p>
                    </div>
                </div>
        
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-red-400 p-2 text-lg transition-colors cursor-pointer"
                        title="ចាកចេញ">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA (Right) -->
        <div class="flex-1 pl-64 flex flex-col min-h-screen">

            <!-- Header (Top Bar ពណ៌ស ដែលទាញពី Dashboard មក) -->
            @isset($header)
                <header
                    class="sticky top-0 z-50 bg-white flex items-center justify-between px-8 h-20 border-b border-slate-100 shadow-sm">
                    <div class="w-full">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Main Slot Content -->
            <main class="flex-1 p-8 bg-slate-50">
                {{ $slot }}
            </main>

        </div>

    </div>
</body>

</html>
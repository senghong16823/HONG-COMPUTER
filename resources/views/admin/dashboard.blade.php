<x-app-layout>
    {{-- Slot Header Filter & Quick Action --}}
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <!-- Left (Title) -->
            <h2 class="text-xl font-bold text-slate-900 leading-tight">
                {{ __('ទិដ្ឋភាពទូទៅ (Dashboard Overview)') }}
            </h2>
    
            <!-- Right (Filter & Button) -->
            <div class="flex items-center gap-3">
                <!-- Date Filter -->
                <div class="relative">
                    <select
                        class="appearance-none bg-white border border-slate-200 text-slate-700 text-sm rounded-lg px-4 py-2.5 pr-8 outline-none hover:border-slate-300 transition-colors shadow-sm cursor-pointer font-medium">
                        <option value="today">ទិន្នន័យថ្ងៃនេះ</option>
                        <option value="yesterday">ម្សិលមិញ</option>
                        <option value="this_week">សប្តាហ៍នេះ</option>
                        <option value="this_month">ខែនេះ</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
    
                <!-- Quick POS Button -->
                <a href="#"
                    class="flex items-center gap-2 px-4 py-2.5 bg-slate-900 text-white rounded-lg text-sm font-medium hover:bg-slate-800 transition-colors shadow-sm group">
                    <i class="fa-solid fa-cash-register group-hover:scale-110 transition-transform"></i>
                    <span>បើក POS</span>
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Body Main Content --}}
    <div class="py-6 min-h-screen text-slate-800 font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 1. STATS CARDS (4 ប្រអប់ E-commerce Standard) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- 1.1 Revenue Card -->
                <div
                    class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">ចំណូលសរុប
                            (Revenue)</span>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-lg transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-dollar-sign text-lg"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">$8,450.00</p>
                        <p class="text-sm text-emerald-600 mt-2 flex items-center gap-1 font-medium">
                            <i class="fa-solid fa-arrow-trend-up"></i> +18.4% ធៀបម្សិលមិញ
                        </p>
                    </div>
                </div>

                <!-- 1.2 Orders Card -->
                <div
                    class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">ការបញ្ជាទិញ
                            (Orders)</span>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-bag-shopping text-lg"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">24</p>
                        <p class="text-sm text-blue-600 mt-2 flex items-center gap-1 font-medium">
                            <i class="fa-solid fa-truck-fast"></i> 3 កំពុងដឹកជញ្ជូន
                        </p>
                    </div>
                </div>

                <!-- 1.3 Customers Card -->
                <div
                    class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">អតិថិជនថ្មី
                            (Customers)</span>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-purple-50 text-purple-600 rounded-lg transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-users text-lg"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">12</p>
                        <p class="text-sm text-purple-600 mt-2 flex items-center gap-1 font-medium">
                            <i class="fa-solid fa-user-plus"></i> +5 ថ្ងៃនេះ
                        </p>
                    </div>
                </div>

                <!-- 1.4 Stock Alert Card -->
                <div
                    class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">ព្រមានស្តុក
                            (Stock Alert)</span>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 rounded-lg transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-red-600">8 <span
                                class="text-sm font-normal text-slate-500">មុខទំនិញ</span></p>
                        <a href="#"
                            class="text-sm text-red-500 mt-2 flex items-center gap-1 font-medium hover:underline">
                            រៀបចំការកុម្ម៉ង់ស្តុកថ្មី <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

            </div>

            <!-- 2. DATA TABLES & LISTS (Grid 12 Cols) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- 2.1 Recent Orders Table (Col 8) -->
                <div class="lg:col-span-8 bg-white border border-slate-100 rounded-xl shadow-sm">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-bold text-slate-800 text-base">ការបញ្ជាទិញថ្មីៗ (Recent Orders)</h3>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:underline">មើលទាំងអស់</a>
                    </div>

                    <div class="overflow-x-auto p-2">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead>
                                <tr class="text-slate-500 uppercase text-xs">
                                    <th class="py-3 px-4 font-medium">លេខកូដ / អតិថិជន</th>
                                    <th class="py-3 px-4 font-medium">ទំនិញ (Items)</th>
                                    <th class="py-3 px-4 font-medium">តម្លៃសរុប</th>
                                    <th class="py-3 px-4 font-medium">ស្ថានភាព</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <!-- Order Row 1 -->
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <p class="font-bold text-slate-900">#ORD-8842</p>
                                        <p class="text-slate-500 text-xs">Vireak Roth</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="font-medium text-slate-800">Gold One Beast Rig</p>
                                        <p class="text-slate-500 text-xs">Ryzen 7 9800X3D • MSI RTX 5080</p>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-slate-900">$2,615.00</td>
                                    <td class="py-3 px-4">
                                        <span
                                            class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">Pending</span>
                                    </td>
                                </tr>
                                <!-- Order Row 2 -->
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <p class="font-bold text-slate-900">#ORD-8845</p>
                                        <p class="text-slate-500 text-xs">Sok Heng</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="font-medium text-slate-800">2x Asus ProArt PA278CGRV</p>
                                        <p class="text-slate-500 text-xs">2K QHD 144Hz IPS 100% sRGB</p>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-slate-900">$727.00</td>
                                    <td class="py-3 px-4">
                                        <span
                                            class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">Completed</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2.2 Top Selling Products (Col 4) -->
                <div class="lg:col-span-4 bg-white border border-slate-100 rounded-xl shadow-sm">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="font-bold text-slate-800 text-base">លក់ដាច់បំផុត (Top Selling)</h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Product Item 1 -->
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-microchip text-slate-500 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-slate-900 text-sm truncate">AMD Ryzen 7 9800X3D</p>
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-slate-500 text-xs">លក់បាន 24 គ្រឿង</p>
                                    <p class="text-emerald-600 text-xs font-bold">$12,500</p>
                                </div>
                            </div>
                        </div>

                        <!-- Product Item 2 -->
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-memory text-slate-500 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-slate-900 text-sm truncate">Corsair Vengeance 32GB DDR5</p>
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-slate-500 text-xs">លក់បាន 18 គ្រឿង</p>
                                    <p class="text-emerald-600 text-xs font-bold">$3,150</p>
                                </div>
                            </div>
                        </div>

                        <!-- Product Item 3 -->
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-desktop text-slate-500 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-slate-900 text-sm truncate">Asus ProArt 27" Monitor</p>
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-slate-500 text-xs">លក់បាន 12 គ្រឿង</p>
                                    <p class="text-emerald-600 text-xs font-bold">$4,360</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
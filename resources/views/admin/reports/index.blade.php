<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 w-full">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-blue-600"></i>
                {{ __('របាយការណ៍ & វិភាគទិន្នន័យ (Reports & Analytics)') }}
            </h2>

            <!-- Range Filter Form -->
            <form method="GET" action="{{ route('admin.reports.index') }}" class="flex items-center gap-2">
                <select name="range" onchange="this.form.submit()"
                        class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-blue-500 shadow-sm cursor-pointer">
                    <option value="today" {{ $range === 'today' ? 'selected' : '' }}>ថ្ងៃនេះ (Today)</option>
                    <option value="yesterday" {{ $range === 'yesterday' ? 'selected' : '' }}>ម្សិលមិញ (Yesterday)</option>
                    <option value="this_week" {{ $range === 'this_week' ? 'selected' : '' }}>សប្តាហ៍នេះ (This Week)</option>
                    <option value="this_month" {{ $range === 'this_month' ? 'selected' : '' }}>ខែនេះ (This Month)</option>
                    <option value="this_year" {{ $range === 'this_year' ? 'selected' : '' }}>ឆ្នាំនេះ (This Year)</option>
                    <option value="all" {{ $range === 'all' ? 'selected' : '' }}>គ្រប់ពេលវេលា (All Time)</option>
                </select>
                <button type="button" onclick="window.print()" class="p-2 px-3 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition flex items-center gap-1 cursor-pointer">
                    <i class="fa-solid fa-print"></i> Print
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 1. METRICS CARDS (4 Cards) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Revenue -->
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-2">
                    <div class="flex justify-between items-center text-slate-500 text-xs font-medium">
                        <span>ចំណូលលក់សរុប</span>
                        <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </span>
                    </div>
                    <p class="text-2xl font-bold text-slate-900">${{ number_format($totalRevenue, 2) }}</p>
                    <p class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-circle-check"></i> ទូទាត់រួចរាល់
                    </p>
                </div>

                <!-- Orders Count -->
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-2">
                    <div class="flex justify-between items-center text-slate-500 text-xs font-medium">
                        <span>ចំនួនការកុម្ម៉ង់</span>
                        <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-receipt"></i>
                        </span>
                    </div>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalOrders }}</p>
                    <p class="text-[11px] text-blue-600 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-check-double"></i> បានបញ្ចប់៖ {{ $completedOrders }}
                    </p>
                </div>

                <!-- Avg Order Value -->
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-2">
                    <div class="flex justify-between items-center text-slate-500 text-xs font-medium">
                        <span>តម្លៃកុម្ម៉ង់ជាមធ្យម (AOV)</span>
                        <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </span>
                    </div>
                    <p class="text-2xl font-bold text-slate-900">${{ number_format($avgOrderValue, 2) }}</p>
                    <p class="text-[11px] text-slate-400 font-medium">ក្នុងមួយវិក្កយបត្រ</p>
                </div>

                <!-- Discount Given -->
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-2">
                    <div class="flex justify-between items-center text-slate-500 text-xs font-medium">
                        <span>បញ្ចុះតម្លៃសរុប</span>
                        <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                    </div>
                    <p class="text-2xl font-bold text-amber-600">${{ number_format($totalDiscount, 2) }}</p>
                    <p class="text-[11px] text-slate-400 font-medium">តាមរយៈប្រូម៉ូសិន</p>
                </div>
            </div>

            <!-- 2. CHARTS & DISTRIBUTION (Grid 2 Cols) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- 2.1 Payment Method Breakdown -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-blue-600"></i>
                        <span>ចំណូលតាមវិធីសាស្ត្រទូទាត់ (Payment Methods)</span>
                    </h3>

                    <div class="space-y-3 pt-2">
                        <!-- Cash -->
                        <div>
                            <div class="flex justify-between text-xs font-medium mb-1">
                                <span class="text-slate-600 flex items-center gap-1.5"><i class="fa-solid fa-money-bill-wave text-emerald-500"></i> សាច់ប្រាក់ (Cash)</span>
                                <span class="font-bold text-slate-900">${{ number_format($paymentMethods['cash'], 2) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-2.5 rounded-full" style="width: {{ $totalRevenue > 0 ? ($paymentMethods['cash'] / $totalRevenue) * 100 : 0 }}%"></div>
                            </div>
                        </div>

                        <!-- ABA KHQR -->
                        <div>
                            <div class="flex justify-between text-xs font-medium mb-1">
                                <span class="text-slate-600 flex items-center gap-1.5"><i class="fa-solid fa-qrcode text-blue-500"></i> ABA KHQR</span>
                                <span class="font-bold text-slate-900">${{ number_format($paymentMethods['aba_khqr'], 2) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ $totalRevenue > 0 ? ($paymentMethods['aba_khqr'] / $totalRevenue) * 100 : 0 }}%"></div>
                            </div>
                        </div>

                        <!-- Card -->
                        <div>
                            <div class="flex justify-between text-xs font-medium mb-1">
                                <span class="text-slate-600 flex items-center gap-1.5"><i class="fa-solid fa-credit-card text-purple-500"></i> កាតធនាគារ (Card)</span>
                                <span class="font-bold text-slate-900">${{ number_format($paymentMethods['card'], 2) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-purple-500 h-2.5 rounded-full" style="width: {{ $totalRevenue > 0 ? ($paymentMethods['card'] / $totalRevenue) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2.2 Sales Channel Distribution -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-store text-blue-600"></i>
                        <span>ប្រភពនៃការលក់ (Sales Channels)</span>
                    </h3>

                    <div class="space-y-4 pt-2">
                        <!-- POS Storefront -->
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-cash-register"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-xs">លក់ផ្ទាល់នៅហាង (POS)</p>
                                    <p class="text-[11px] text-slate-400">Walk-in Storefront</p>
                                </div>
                            </div>
                            <span class="font-bold text-base text-slate-900">${{ number_format($sources['pos'], 2) }}</span>
                        </div>

                        <!-- Web Orders -->
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-800 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-globe"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-xs">កុម្ម៉ង់តាមគេហទំព័រ (Online Store)</p>
                                    <p class="text-[11px] text-slate-400">Web Storefront</p>
                                </div>
                            </div>
                            <span class="font-bold text-base text-slate-900">${{ number_format($sources['web'], 2) }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 3. TOP PRODUCTS LEADERBOARD -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-6 space-y-4">
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <i class="fa-solid fa-trophy text-amber-500"></i>
                    <span>ទំនិញលក់ដាច់បំផុតក្នុងកំឡុងពេលនេះ (Top Selling Products)</span>
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                                <th class="p-3">ចំណាត់ថ្នាក់</th>
                                <th class="p-3">ឈ្មោះទំនិញ</th>
                                <th class="p-3 text-center">ចំនួនលក់ដាច់</th>
                                <th class="p-3 text-right">ចំណូលសរុប</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            @forelse($topProducts as $index => $prod)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-3 font-bold text-slate-400">#{{ $index + 1 }}</td>
                                    <td class="p-3 font-bold text-slate-900">{{ $prod->product_name }}</td>
                                    <td class="p-3 text-center font-bold text-blue-600">{{ $prod->units_sold }} គ្រឿង</td>
                                    <td class="p-3 text-right font-bold text-emerald-600">${{ number_format($prod->revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-slate-400">
                                        មិនមានទិន្នន័យលក់ក្នុងកំឡុងពេលដែលបានជ្រើសរើសឡើយ
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

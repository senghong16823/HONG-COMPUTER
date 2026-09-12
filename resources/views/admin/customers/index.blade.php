<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-users text-blue-600"></i>
            {{ __('គ្រប់គ្រងអតិថិជន (Customer Management)') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Search & Count Header -->
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-slate-800">អតិថិជនសរុបក្នុងប្រព័ន្ធ៖ <span class="text-blue-600 font-extrabold">{{ $customers->total() }}</span> នាក់</p>
                </div>

                <form method="GET" action="{{ route('admin.customers.index') }}" class="w-full md:w-80 flex gap-2">
                    <div class="relative w-full">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="ស្វែងរកតាមឈ្មោះ ឬ Email..."
                               class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition cursor-pointer">
                        ស្វែងរក
                    </button>
                </form>
            </div>

            <!-- Customers Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-900 border-b border-slate-100 text-sm uppercase text-white tracking-wider">
                                <th class="p-4 w-16 text-center">ល.រ</th>
                                <th class="p-4">អតិថិជន</th>
                                <th class="p-4">អ៊ីមែល (Email)</th>
                                <th class="p-4 text-center">តួនាទី (Role)</th>
                                <th class="p-4 text-center">ចំនួនកុម្ម៉ង់ (Orders)</th>
                                <th class="p-4 text-center">ចំណាយសរុប (Spent)</th>
                                <th class="p-4">កាលបរិច្ឆេទចុះឈ្មោះ</th>
                                <th class="p-4 text-center w-28">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-slate-700">
                            @forelse ($customers as $index => $c)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    <td class="p-4 text-center text-slate-400 font-medium">
                                        {{ $customers->firstItem() + $index }}
                                    </td>

                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm">
                                                {{ mb_substr($c->name, 0, 1, 'UTF-8') }}
                                            </div>
                                            <span class="font-bold text-slate-900">{{ $c->name }}</span>
                                        </div>
                                    </td>

                                    <td class="p-4 text-slate-600 text-xs">
                                        {{ $c->email }}
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($c->is_admin)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                                Admin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                                Customer
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center font-bold text-slate-800">
                                        {{ $c->orders_count ?? 0 }}
                                    </td>

                                    <td class="p-4 text-center font-bold text-emerald-600">
                                        ${{ number_format($c->total_spent ?? 0, 2) }}
                                    </td>

                                    <td class="p-4 text-xs text-slate-400">
                                        {{ $c->created_at->format('d M Y') }}
                                    </td>

                                    <td class="p-4 text-center">
                                        <a href="{{ route('admin.customers.show', $c->id) }}"
                                           class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition inline-flex items-center gap-1">
                                            <i class="fa-solid fa-eye"></i> មើល
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-12 text-center text-slate-400">
                                        មិនមានទិន្នន័យអតិថិជននៅឡើយទេ
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($customers->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

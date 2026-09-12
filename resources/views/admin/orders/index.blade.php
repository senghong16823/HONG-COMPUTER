<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-bag-shopping text-blue-600"></i>
            {{ __('គ្រប់គ្រងការបញ្ជាទិញ (Order Management)') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Alert --}}
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm flex items-center justify-between"
                    x-data="{ show: true }" x-show="show">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                        <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <!-- Controls: Status Tabs & Search -->
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Status Filter Pills -->
                <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
                    <a href="{{ route('admin.orders.index') }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ !$status || $status === 'all' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        ទាំងអស់ ({{ $counts['all'] }})
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        រង់ចាំ ({{ $counts['pending'] }})
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ $status === 'processing' ? 'bg-blue-500 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        កំពុងរៀបចំ ({{ $counts['processing'] }})
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ $status === 'completed' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        បានបញ្ចប់ ({{ $counts['completed'] }})
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ $status === 'cancelled' ? 'bg-rose-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        បោះបង់ ({{ $counts['cancelled'] }})
                    </a>
                </div>

                <!-- Search -->
                <form method="GET" action="{{ route('admin.orders.index') }}" class="w-full md:w-72 flex gap-2">
                    @if($status)
                        <input type="hidden" name="status" value="{{ $status }}">
                    @endif
                    <div class="relative w-full">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="ស្វែងរកតាមលេខកូដ, ឈ្មោះ..."
                               class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                    </div>
                    <button type="submit" class="px-3.5 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition cursor-pointer">
                        ស្វែងរក
                    </button>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-900 border-b border-slate-100 text-sm uppercase text-white tracking-wider">
                                <th class="p-4">លេខកូដ / កាលបរិច្ឆេទ</th>
                                <th class="p-4">អតិថិជន</th>
                                <th class="p-4">ចំនួនទំនិញ</th>
                                <th class="p-4">តម្លៃសរុប</th>
                                <th class="p-4">ការទូទាត់</th>
                                <th class="p-4">ស្ថានភាព</th>
                                <th class="p-4 text-center w-36">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-slate-700">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    {{-- Order Number & Date --}}
                                    <td class="p-4">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="font-bold text-blue-600 hover:underline">
                                            #{{ $order->order_number }}
                                        </a>
                                        <p class="text-xs text-slate-400 mt-0.5">
                                            {{ $order->created_at->format('d M Y, h:i A') }}
                                        </p>
                                    </td>

                                    {{-- Customer --}}
                                    <td class="p-4">
                                        <p class="font-semibold text-slate-800">{{ $order->customer_name }}</p>
                                        @if($order->customer_phone)
                                            <p class="text-xs text-slate-400">{{ $order->customer_phone }}</p>
                                        @endif
                                    </td>

                                    {{-- Items Count --}}
                                    <td class="p-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                            {{ $order->items->sum('quantity') }} មុខ
                                        </span>
                                    </td>

                                    {{-- Total Amount --}}
                                    <td class="p-4 font-bold text-base text-slate-900">
                                        ${{ number_format($order->total_amount, 2) }}
                                    </td>

                                    {{-- Payment --}}
                                    <td class="p-4">
                                        <p class="text-xs font-semibold uppercase text-slate-700">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                                        @if($order->payment_status === 'paid')
                                            <span class="inline-flex items-center text-[10px] font-bold text-emerald-600">
                                                <i class="fa-solid fa-circle-check me-1"></i> បានបង់ប្រាក់
                                            </span>
                                        @elseif($order->payment_status === 'unpaid')
                                            <span class="inline-flex items-center text-[10px] font-bold text-amber-600">
                                                <i class="fa-solid fa-clock me-1"></i> មិនទាន់បង់
                                            </span>
                                        @else
                                            <span class="inline-flex items-center text-[10px] font-bold text-rose-600">
                                                <i class="fa-solid fa-rotate-left me-1"></i> សងប្រាក់វិញ
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Order Status --}}
                                    <td class="p-4">
                                        @if($order->status === 'completed')
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">
                                                Completed
                                            </span>
                                        @elseif($order->status === 'pending')
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">
                                                Pending
                                            </span>
                                        @elseif($order->status === 'processing')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">
                                                Processing
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-full">
                                                Cancelled
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                               class="bg-blue-600 hover:bg-blue-700 p-2 text-white rounded-lg text-xs transition inline-flex items-center gap-1"
                                               title="មើលវិក្កយបត្រ">
                                                <i class="fa-solid fa-eye"></i> មើល
                                            </a>

                                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                                  onsubmit="return confirm('តើអ្នកពិតជាចង់លុបការបញ្ជាទិញ #{{ $order->order_number }} នេះមែនទេ?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-500 hover:bg-rose-600 p-2 text-white rounded-lg text-xs transition cursor-pointer"
                                                        title="លុបចេញ">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <i class="fa-solid fa-bag-shopping text-4xl text-slate-300"></i>
                                            <p class="text-base font-medium">មិនទាន់មានទិន្នន័យការបញ្ជាទិញនៅឡើយទេ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

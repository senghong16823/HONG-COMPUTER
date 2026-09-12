<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-ticket text-blue-600"></i>
            {{ __('គ្រប់គ្រងប្រូម៉ូសិន & គូប៉ុង (Coupons & Promotions)') }}
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

            {{-- Top Action --}}
            <div class="flex justify-between items-center">
                <p class="text-lg text-yellow-500 font-bold">បញ្ជីកូដបញ្ចុះតម្លៃ និងប្រូម៉ូសិនក្នុងប្រព័ន្ធ</p>
                <a href="{{ route('admin.coupons.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm hover:shadow transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>បង្កើតគូប៉ុងថ្មី</span>
                </a>
            </div>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-900 border-b border-slate-100 text-sm uppercase text-white tracking-wider">
                                <th class="p-4 w-16 text-center">ល.រ</th>
                                <th class="p-4">កូដគូប៉ុង (Code)</th>
                                <th class="p-4">ប្រភេទ & តម្លៃ</th>
                                <th class="p-4 text-center">ទិញអប្បបរមា</th>
                                <th class="p-4 text-center">បានប្រើ</th>
                                <th class="p-4 text-center">ស្ថានភាព</th>
                                <th class="p-4 text-center w-36">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-slate-700">
                            @forelse ($coupons as $coupon)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    <td class="p-4 text-center font-medium text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="p-4">
                                        <div class="flex items-center gap-2">
                                            <span class="px-3 py-1 bg-amber-100 text-amber-900 font-mono font-bold text-xs rounded-lg border border-amber-200 tracking-wider">
                                                {{ $coupon->code }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        @if($coupon->type === 'percent')
                                            <span class="font-bold text-blue-600 text-sm">បញ្ចុះ {{ $coupon->value }}%</span>
                                            @if($coupon->max_discount_amount)
                                                <span class="text-xs text-slate-400 block">(អតិបរមា ${{ number_format($coupon->max_discount_amount, 2) }})</span>
                                            @endif
                                        @else
                                            <span class="font-bold text-emerald-600 text-sm">បញ្ចុះ ${{ number_format($coupon->value, 2) }}</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center text-xs text-slate-600 font-semibold">
                                        ${{ number_format($coupon->min_order_amount, 2) }}
                                    </td>

                                    <td class="p-4 text-center">
                                        <span class="text-xs font-semibold text-slate-700">
                                            {{ $coupon->used_count }} {{ $coupon->usage_limit ? '/ ' . $coupon->usage_limit : '' }}
                                        </span>
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($coupon->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                សកម្ម
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                                អសកម្ម
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                               class="bg-green-500 hover:bg-green-600 p-2 text-white rounded-lg text-xs transition inline-flex items-center gap-1"
                                               title="កែប្រែ">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST"
                                                  onsubmit="return confirm('តើអ្នកប្រាកដជាចង់លុបគូប៉ុង «{{ $coupon->code }}» នេះមែនទេ?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 p-2 text-white rounded-lg text-xs transition cursor-pointer"
                                                        title="លុបចេញ">
                                                    <i class="fa-solid fa-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <i class="fa-solid fa-ticket text-4xl text-slate-300"></i>
                                            <p class="text-base font-medium">មិនទាន់មានទិន្នន័យគូប៉ុងនៅឡើយទេ</p>
                                            <a href="{{ route('admin.coupons.create') }}" class="text-sm text-blue-600 hover:underline">
                                                + ចុចទីនេះដើម្បីបង្កើតគូប៉ុងថ្មី
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($coupons->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $coupons->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

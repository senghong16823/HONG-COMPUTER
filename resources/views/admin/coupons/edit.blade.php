<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-amber-500"></i>
            {{ __('កែប្រែគូប៉ុងបញ្ចុះតម្លៃ') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <h3 class="text-xl font-bold text-slate-800">កែប្រែ៖ {{ $coupon->code }}</h3>
                        <p class="text-xs text-slate-400 mt-1">កែប្រែព័ត៌មាន និងលក្ខខណ្ឌបញ្ចុះតម្លៃ</p>
                    </div>

                    <!-- Code & Type -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">កូដគូប៉ុង (Coupon Code) *</label>
                            <input type="text" name="code" value="{{ old('code', $coupon->code) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm uppercase font-mono font-bold outline-none focus:ring-2 focus:ring-blue-500">
                            @error('code') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">ប្រភេទបញ្ចុះតម្លៃ *</label>
                            <select name="type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="percent" {{ old('type', $coupon->type) === 'percent' ? 'selected' : '' }}>ភាគរយ (% Off)</option>
                                <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>សាច់ប្រាក់ថេរ ($ Off)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Value & Min Order -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">តម្លៃបញ្ចុះ (Value) *</label>
                            <input type="number" step="0.01" name="value" value="{{ old('value', $coupon->value) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            @error('value') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">ទិញអប្បបរមា ($ Min Order)</label>
                            <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Max Discount & Usage Limit -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">បញ្ចុះអតិបរមា ($ Max Discount)</label>
                            <input type="number" step="0.01" name="max_discount_amount" value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">កំណត់ចំនួនដងប្រើ (Usage Limit)</label>
                            <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Active Toggle -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 border-slate-300">
                        <label for="is_active" class="text-sm font-medium text-slate-700">ដាក់ឱ្យដំណើរការ (Active)</label>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2 text-sm text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition font-medium">
                            បោះបង់
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition cursor-pointer shadow-sm">
                            <i class="fa-solid fa-check me-1"></i> រក្សាទុកការកែប្រែ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

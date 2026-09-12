<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-gear text-blue-600"></i>
            {{ __('ការកំណត់ប្រព័ន្ធ & ព័ត៌មានហាង (Store Settings)') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

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

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf

                <!-- 1. Store Profile -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-store text-amber-500"></i>
                            <span>ព័ត៌មានទូទៅរបស់ហាង (Store Information)</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">ព័ត៌មាននេះនឹងបង្ហាញនៅលើវិក្កយបត្រ និងទំព័រ Storefront</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">ឈ្មោះហាង *</label>
                            <input type="text" name="store_name" value="{{ old('store_name', $settings['store_name']) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">អ៊ីមែលហាង (Email) *</label>
                            <input type="email" name="store_email" value="{{ old('store_email', $settings['store_email']) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">លេខទូរស័ព្ទទំនាក់ទំនង</label>
                            <input type="text" name="store_phone" value="{{ old('store_phone', $settings['store_phone']) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">អាសយដ្ឋានហាង</label>
                            <input type="text" name="store_address" value="{{ old('store_address', $settings['store_address']) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- 2. Financial & POS Settings -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-coins text-emerald-500"></i>
                            <span>ការកំណត់រូបិយប័ណ្ណ & ពន្ធ (Financial Settings)</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">កំណត់រូបិយប័ណ្ណបង្ហាញលើទំនិញ និងអត្រាពន្ធ</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">និមិត្តសញ្ញារូបិយប័ណ្ណ *</label>
                            <input type="text" name="currency_symbol" value="{{ old('currency_symbol', $settings['currency_symbol']) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500 font-bold">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">អត្រាពន្ធ (% Tax Rate)</label>
                            <input type="number" step="0.01" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate']) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">ថ្លៃដឹកជញ្ជូនស្តង់ដារ ($)</label>
                            <input type="number" step="0.01" name="shipping_fee" value="{{ old('shipping_fee', $settings['shipping_fee']) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- 3. Social & Contact -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-share-nodes text-blue-500"></i>
                            <span>បណ្តាញសង្គម & ជំនួយ (Social Media Links)</span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Facebook Page URL</label>
                            <input type="url" name="facebook_page" value="{{ old('facebook_page', $settings['facebook_page']) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">លេខ Telegram / Channel</label>
                            <input type="text" name="telegram_number" value="{{ old('telegram_number', $settings['telegram_number']) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Save Action -->
                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition cursor-pointer shadow-lg shadow-blue-600/20 flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> រក្សាទុកការកំណត់ទាំងអស់
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>

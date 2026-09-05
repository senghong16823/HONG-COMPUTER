<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('បង្កើតប្រភេទកុំព្យូទ័រថ្មី') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                <form action="{{ route('categories.store') }}" method="POST"
                    class="bg-white p-8 rounded-2xl shadow-lg border border-slate-100 max-w-2xl mx-auto"
                    x-data="{ selectedIcon: '{{ old('icon', 'fa-laptop') }}' }">
                    @csrf
                
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                                <i class="fa-solid fa-folder-plus text-xl"></i>
                            </div>
                            <span>បង្កើតប្រភេទទំនិញថ្មី</span>
                        </h2>
                        <p class="text-slate-500 text-sm mt-1">បំពេញព័ត៌មានខាងក្រោមដើម្បីបង្កើត Category ថ្មីក្នុងប្រព័ន្ធ</p>
                    </div>
                
                    {{-- ឈ្មោះ Category --}}
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                            ឈ្មោះប្រភេទកុំព្យូទ័រ <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            placeholder="ឧទាហរណ៍៖ Laptop, Desktop, Accessories..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition duration-200 outline-none text-slate-800 placeholder-slate-400 @error('name') border-rose-500 @enderror"
                            required>
                        @error('name')
                            <p class="text-rose-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                
                    {{-- ជ្រើសរើស Icon តាមរយៈរូបភាព (Visual Icon Selector) --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            ជ្រើសរើសរូប Icon <span class="text-rose-500">*</span>
                        </label>
                
                        {{-- Hidden Input សម្រាប់ផ្ញើ Value ទៅ Backend --}}
                        <input type="hidden" name="icon" x-model="selectedIcon">
                
                        {{-- បញ្ជីរូប Icon សម្រាប់ឱ្យគាត់ចុចជ្រើសរើស --}}
                        <div
                            class="grid grid-cols-6 gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 max-h-52 overflow-y-auto custom-scrollbar">
                            @php
                                // បញ្ជី Icon ប្រភេទកុំព្យូទ័រ និងសម្ភារៈអេឡិចត្រូនិកដែលនិយមប្រើបំផុត
                                $popularIcons = [
                                    'fa-laptop' => 'Laptop',
                                    'fa-desktop' => 'Desktop',
                                    'fa-display' => 'Monitor',
                                    'fa-mobile-screen-button' => 'Phone',
                                    'fa-tablet-screen-button' => 'Tablet',
                                    'fa-gamepad' => 'Gaming',
                                    'fa-keyboard' => 'Keyboard',
                                    'fa-mouse' => 'Mouse',
                                    'fa-headphones' => 'Headset',
                                    'fa-print' => 'Printer',
                                    'fa-hard-drive' => 'Storage',
                                    'fa-memory' => 'RAM/Components',
                                    'fa-microchip' => 'CPU',
                                    'fa-wifi' => 'Network',
                                    'fa-plug' => 'Accessories',
                                    'fa-camera' => 'Camera/CCTV',
                                    'fa-charge-station' => 'Power/UPS',
                                    'fa-box' => 'Other Box',
                                ];
                            @endphp
                
                            @foreach($popularIcons as $iconClass => $label)
                                <button type="button" @click="selectedIcon = '{{ $iconClass }}'"
                                    :class="selectedIcon === '{{ $iconClass }}' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30 scale-105 border-blue-600' : 'bg-white text-slate-600 hover:bg-slate-100 border-slate-200'"
                                    class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-200 cursor-pointer group"
                                    title="{{ $label }}">
                                    <i class="fa-solid {{ $iconClass }} text-xl mb-1 group-hover:scale-110 transition-transform"></i>
                                    <span class="text-[10px] truncate w-full text-center opacity-80"
                                        :class="selectedIcon === '{{ $iconClass }}' ? 'text-white' : 'text-slate-500'">{{ $label }}</span>
                                </button>
                            @endforeach
                        </div>
                
                        {{-- បង្ហាញ Icon ដែលបានជ្រើសរើស --}}
                        <div class="mt-3 flex items-center gap-2 text-sm text-slate-600 bg-blue-50/60 px-3 py-2 rounded-lg w-fit">
                            <span>Icon ដែលបានជ្រើសរើស៖</span>
                            <i class="fa-solid text-blue-600 text-lg" :class="selectedIcon"></i>
                        </div>
                    </div>
                
                    {{-- ការពិពណ៌នា --}}
                    <div class="mb-8">
                        <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                            ការពិពណ៌នា <span class="text-slate-400 font-normal">(ជាជម្រើស)</span>
                        </label>
                        <textarea name="description" id="description" rows="3" placeholder="ពិពណ៌នាបន្ថែមអំពីប្រភេទកុំព្យូទ័រនេះ..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition duration-200 outline-none text-slate-800 placeholder-slate-400">{{ old('description') }}</textarea>
                    </div>
                
                    {{-- ប៊ូតុងសកម្មភាព (Buttons) --}}
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('categories.index') }}"
                            class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-xmark"></i>
                            <span>បោះបង់</span>
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl shadow-lg shadow-blue-600/20 transition duration-200 flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-check"></i>
                            <span>រក្សាទុកទិន្នន័យ</span>
                        </button>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
{{-- resources/views/categories/edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('កែប្រែប្រភេទទំនិញ') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('categories.update', $category->id) }}" method="POST"
                class="bg-white p-8 rounded-2xl shadow-lg border border-slate-100 max-w-2xl mx-auto"
                x-data="{ selectedIcon: '{{ old('icon', $category->icon ?? 'fa-laptop') }}' }">

                @csrf
                @method('PUT') {{-- ដាច់ខាតត្រូវមាន method PUT សម្រាប់កែប្រែ --}}

                <div class="mb-8 border-b border-slate-100 pb-4">
                    <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                        <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl">
                            <i class="fa-solid fa-pen-to-square text-xl"></i>
                        </div>
                        <span>កែប្រែប្រភេទទំនិញ៖ {{ $category->name }}</span>
                    </h2>
                </div>

                {{-- ឈ្មោះ Category --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                        ឈ្មោះប្រភេទកុំព្យូទ័រ <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none"
                        required>
                </div>

                {{-- Icon Selector --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        ជ្រើសរើសរូប Icon <span class="text-rose-500">*</span>
                    </label>
                    <input type="hidden" name="icon" x-model="selectedIcon">

                    <div
                        class="grid grid-cols-6 gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 max-h-52 overflow-y-auto">
                        @php
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
                                class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-200 cursor-pointer group">
                                <i class="fa-solid {{ $iconClass }} text-xl mb-1"></i>
                                <span class="text-[10px] truncate w-full text-center"
                                    :class="selectedIcon === '{{ $iconClass }}' ? 'text-white' : 'text-slate-500'">{{ $label }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- ការពិពណ៌នា --}}
                <div class="mb-8">
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">ការពិពណ៌នា</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">{{ old('description', $category->description) }}</textarea>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('categories.index') }}"
                        class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">បោះបង់</a>
                    <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-lg shadow-amber-600/20">កែប្រែទិន្នន័យ</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
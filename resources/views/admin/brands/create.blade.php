<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-folder-plus text-blue-600"></i>
            {{ __('បង្កើតម៉ាកយីហោថ្មី (Add Brand)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <h3 class="text-xl font-bold text-slate-800">ព័ត៌មានម៉ាកយីហោ</h3>
                        <p class="text-xs text-slate-400 mt-1">បំពេញទិន្នន័យដើម្បីបន្ថែមម៉ាកកុំព្យូទ័រថ្មីក្នុងប្រព័ន្ធ</p>
                    </div>

                    <!-- Brand Name -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">ឈ្មោះម៉ាកយីហោ *</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="ឧ. ASUS, Apple, MSI..." required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Website -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">គេហទំព័រផ្លូវការ (Website URL)</label>
                        <input type="url" name="website" value="{{ old('website') }}" placeholder="https://www.example.com"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        @error('website') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Logo Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">រូបសញ្ញាម៉ាក (Logo)</label>
                        <input type="file" name="logo" accept="image/*"
                               class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        @error('logo') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">ការពិពណ៌នា</label>
                        <textarea name="description" rows="3" placeholder="ពិពណ៌នាបន្ថែមអំពីម៉ាកនេះ..."
                                  class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-4 h-4 rounded text-blue-600 border-slate-300">
                        <label for="is_active" class="text-sm font-medium text-slate-700">ដាក់ឱ្យដំណើរការភ្លាមៗ (Active)</label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('brands.index') }}" class="px-4 py-2 text-sm text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition font-medium">
                            បោះបង់
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition cursor-pointer shadow-sm">
                            <i class="fa-solid fa-check me-1"></i> រក្សាទុក
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

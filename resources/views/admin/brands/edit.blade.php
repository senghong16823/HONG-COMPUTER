<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-amber-500"></i>
            {{ __('កែប្រែម៉ាកយីហោ (Edit Brand)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-['Kantumruy_Pro',sans-serif]">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <h3 class="text-xl font-bold text-slate-800">កែប្រែ៖ {{ $brand->name }}</h3>
                        <p class="text-xs text-slate-400 mt-1">កែប្រែព័ត៌មានម៉ាកយីហោក្នុងប្រព័ន្ធ</p>
                    </div>

                    <!-- Brand Name -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">ឈ្មោះម៉ាកយីហោ *</label>
                        <input type="text" name="name" value="{{ old('name', $brand->name) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Website -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">គេហទំព័រផ្លូវការ (Website URL)</label>
                        <input type="url" name="website" value="{{ old('website', $brand->website) }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        @error('website') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Logo Upload & Current Preview -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">រូបសញ្ញាម៉ាក (Logo)</label>
                        @if($brand->logo)
                            <div class="flex items-center gap-3 mb-2 p-2 bg-slate-50 rounded-xl border border-slate-200 w-fit">
                                <img src="{{ asset($brand->logo) }}" class="h-10 w-10 object-contain rounded" alt="{{ $brand->name }}">
                                <span class="text-xs text-slate-500">Logo បច្ចុប្បន្ន</span>
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*"
                               class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        @error('logo') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">ការពិពណ៌នា</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $brand->description) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ $brand->is_active ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 border-slate-300">
                        <label for="is_active" class="text-sm font-medium text-slate-700">ដាក់ឱ្យដំណើរការ (Active)</label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('brands.index') }}" class="px-4 py-2 text-sm text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition font-medium">
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

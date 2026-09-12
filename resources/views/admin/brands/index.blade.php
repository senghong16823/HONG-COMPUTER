<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-copyright text-blue-600"></i>
            {{ __('គ្រប់គ្រងម៉ាកយីហោ (Brand Management)') }}
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
                <p class="text-lg text-yellow-500 font-bold">បញ្ជីម៉ាកយីហោកុំព្យូទ័រទាំងអស់</p>
                <a href="{{ route('brands.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm hover:shadow transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>បង្កើតម៉ាកថ្មី</span>
                </a>
            </div>

            {{-- Brands Grid / Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-900 border-b border-slate-100 text-sm uppercase text-white tracking-wider">
                                <th class="p-4 w-16 text-center">ល.រ</th>
                                <th class="p-4">ឈ្មោះម៉ាក</th>
                                <th class="p-4">គេហទំព័រផ្លូវការ</th>
                                <th class="p-4">ការពិពណ៌នា</th>
                                <th class="p-4 text-center">ចំនួនទំនិញ</th>
                                <th class="p-4 text-center">ស្ថានភាព</th>
                                <th class="p-4 text-center w-40">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-slate-700">
                            @forelse ($brands as $index => $brand)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    {{-- number --}}
                                    <td class="p-4 text-center font-medium text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Brand Name & Logo --}}
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            @if($brand->logo)
                                                <img src="{{ asset($brand->logo) }}" class="w-10 h-10 object-contain rounded-lg border border-slate-200 p-1 bg-white" alt="{{ $brand->name }}">
                                            @else
                                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm border border-blue-100">
                                                    {{ substr($brand->name, 0, 2) }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-slate-900">{{ $brand->name }}</p>
                                                <p class="text-[11px] text-slate-400">Slug: {{ $brand->slug }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Website --}}
                                    <td class="p-4">
                                        @if($brand->website)
                                            <a href="{{ $brand->website }}" target="_blank" class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                                {{ parse_url($brand->website, PHP_URL_HOST) ?? $brand->website }}
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-400">—</span>
                                        @endif
                                    </td>

                                    {{-- Description --}}
                                    <td class="p-4 text-xs text-slate-500 max-w-xs truncate">
                                        {{ $brand->description ?? '—' }}
                                    </td>

                                    {{-- Products count --}}
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                            {{ $brand->products_count ?? 0 }} មុខ
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="p-4 text-center">
                                        @if($brand->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                សកម្ម
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                                អសកម្ម
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('brands.edit', $brand->id) }}"
                                               class="bg-green-500 hover:bg-green-600 p-2 text-white rounded-lg text-xs transition inline-flex items-center gap-1"
                                               title="កែប្រែ">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST"
                                                  onsubmit="return confirm('តើអ្នកប្រាកដជាចង់លុបម៉ាក «{{ $brand->name }}» នេះមែនទេ?');" class="inline">
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
                                            <i class="fa-solid fa-copyright text-4xl text-slate-300"></i>
                                            <p class="text-base font-medium">មិនទាន់មានទិន្នន័យម៉ាកយីហោនៅឡើយទេ</p>
                                            <a href="{{ route('brands.create') }}" class="text-sm text-blue-600 hover:underline">
                                                + ចុចទីនេះដើម្បីបង្កើតម៉ាកថ្មី
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($brands->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $brands->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

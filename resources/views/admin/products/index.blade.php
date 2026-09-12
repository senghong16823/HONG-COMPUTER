<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-laptop text-blue-600"></i>
            {{ __('គ្រប់គ្រងកុំព្យូទ័រ (Product Management)') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 1. សារជូនដំណឹង (Flash Message Success) --}}
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm flex items-center justify-between"
                    x-data="{ show: true }" x-show="show">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                        <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            {{-- 2. ប៊ូតុងបញ្ចូនទៅទំព័រ Form --}}
            <div class="flex justify-between items-center">
                <p class="text-lg text-yellow-500 font-bold">បញ្ជីផលិតផលកុំព្យូទ័រសរុបមានក្នុងប្រព័ន្ធ</p>
                <a href="{{ route('products.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm hover:shadow transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>បញ្ចូលកុំព្យូទ័រថ្មី</span>
                </a>
            </div>

            {{-- 3. តារាងបង្ហាញទិន្នន័យ (Table) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-900 border-b border-slate-100 text-sm uppercase text-white tracking-wider">
                                <th class="p-4 w-16 text-center">ល.រ</th>
                                <th class="p-4">រូបភាព</th>
                                <th class="p-4">ឈ្មោះកុំព្យូទ័រ</th>
                                <th class="p-4">ប្រភេទ</th>
                                <th class="p-4">តម្លៃ</th>
                                <th class="p-4 text-center">ស្តុក</th>
                                <th class="p-4 text-center w-48">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-slate-700">
                            @forelse ($products as $index => $product)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    {{-- number --}}
                                    <td class="p-4 text-center font-medium text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- image --}}
                                    <td class="p-4">
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                class="w-14 h-14 object-cover rounded-xl shadow-sm border border-slate-200">
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center text-xs border border-slate-200">
                                                <i class="fa-solid fa-image text-lg"></i>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- product name --}}
                                    <td class="p-4 font-semibold text-slate-800">
                                        {{ $product->name }}
                                        @if($product->cpu || $product->ram)
                                            <p class="text-xs text-slate-400 font-normal mt-0.5">
                                                {{ implode(' • ', array_filter([$product->cpu, $product->ram, $product->storage])) }}
                                            </p>
                                        @endif
                                    </td>

                                    {{-- category --}}
                                    <td class="p-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $product->category->name ?? 'មិនមាន' }}
                                        </span>
                                    </td>

                                    {{-- price --}}
                                    <td class="p-4 text-red-600 font-bold text-base">
                                        ${{ number_format($product->price, 2) }}
                                    </td>

                                    {{-- stock --}}
                                    <td class="p-4 text-center">
                                        @if($product->stock > 5)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                {{ $product->stock }}
                                            </span>
                                        @elseif($product->stock > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                                {{ $product->stock }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                                អស់ស្តុក
                                            </span>
                                        @endif
                                    </td>

                                    {{-- actions --}}
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="bg-green-500 hover:bg-green-600 p-2 text-white rounded-lg transition duration-150 inline-flex items-center gap-1 text-xs"
                                                title="កែប្រែ">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                onsubmit="return confirm('តើអ្នកពិតជាចង់លុបទំនិញ «{{ $product->name }}» នេះមែនទេ?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 p-2 text-white rounded-lg transition duration-150 inline-flex items-center gap-1 text-xs cursor-pointer"
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
                                            <i class="fa-solid fa-laptop text-4xl text-slate-300"></i>
                                            <p class="text-base font-medium">មិនទាន់មានទិន្នន័យកុំព្យូទ័រនៅឡើយទេ</p>
                                            <a href="{{ route('products.create') }}"
                                                class="text-sm text-blue-600 hover:underline">
                                                + ចុចទីនេះដើម្បីបញ្ចូលកុំព្យូទ័រថ្មី
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($products, 'links'))
                    <div class="p-4 border-t border-slate-100">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
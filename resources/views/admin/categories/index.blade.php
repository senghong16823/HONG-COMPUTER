<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-list-check text-blue-600"></i>
            {{ __('គ្រប់គ្រងប្រភេទទំនិញ (Category Management)') }}
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

            {{-- 2. ប៊ូតុងបង្កើតថ្មី --}}
            <div class="flex justify-between items-center">
                <p class="text-lg text-yellow-500 font-bold">បញ្ជីប្រភេទផលិតផលសរុបមានក្នុងប្រព័ន្ធ</p>
                <a href="{{ route('categories.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm hover:shadow transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>+ បង្កើតប្រភេទថ្មី</span>
                </a>
            </div>

            {{-- 3. តារាងបង្ហាញទិន្នន័យ (Table) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-blue-900 border-b border-slate-100 text-lg uppercase  text-white tracking-wider">
                                <th class="p-4 w-16 text-center">ល.រ</th>
                                <th class="p-4">រូប Icon</th>
                                <th class="p-4">ឈ្មោះប្រភេទ</th>
                                <th class="p-4">ការពិពណ៌នា</th>
                                <th class="p-4 text-center w-48">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-slate-700">
                            @forelse ($categories as $index => $category)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    {{-- number --}}
                                    <td class="p-4 text-center font-medium text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Icon --}}
                                    <td class="p-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg border border-blue-100/50">
                                            <i class="fa-solid {{ $category->icon ?? 'fa-folder' }}"></i>
                                        </div>
                                    </td>

                                    {{-- category name --}}
                                    <td class="p-4 font-semibold text-slate-800">
                                        {{ $category->name }}
                                    </td>

                                    {{-- describtion --}}
                                    <td class="p-4 text-slate-500 max-w-xs truncate">
                                        {{ $category->description ?? '—' }}
                                    </td>

                                    {{-- button CRUD Action --}}
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- button Edit --}}
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                class="bg-green-500 p-2 text-white  hover:bg-green-600 rounded-lg transition duration-150"
                                                title="កែប្រែ">
                                                <i class="fa-solid fa-pen-to-square text-base"></i>Edit
                                            </a>

                                            {{-- button Delete --}}
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                                onsubmit="return confirm('តើអ្នកប្រាកដជាចង់លុបប្រភេទ «{{ $category->name }}» នេះមែនទេ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 p-2 text-white hover:bg-red-600 rounded-lg transition duration-150 cursor-pointer"
                                                    title="លុបចេញ">
                                                    <i class="fa-solid fa-trash-can text-base"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- ករណីគ្មានទិន្នន័យ (Empty State) --}}
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <i class="fa-solid fa-folder-open text-4xl text-slate-300"></i>
                                            <p class="text-base font-medium">មិនទាន់មានទិន្នន័យប្រភេទនៅឡើយទេ</p>
                                            <a href="{{ route('categories.create') }}"
                                                class="text-sm text-blue-600 hover:underline">
                                                + ចុចទីនេះដើម្បីបង្កើតថ្មី
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- បើមាន Pagination --}}
                @if(method_exists($categories, 'links'))
                    <div class="p-4 border-t border-slate-100">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
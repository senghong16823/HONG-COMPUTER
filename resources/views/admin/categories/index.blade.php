<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('គ្រប់គ្រងប្រភេទទំនិញ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ប៊ូតុងបង្កើតថ្មី -->
            <div class="mb-4 flex justify-end">
                <a href="{{ route('categories.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                    + បង្កើតប្រភេទថ្មី
                </a>
            </div>

            <!-- តារាងបង្ហាញទិន្នន័យ -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-200 border-b">
                                <th class="p-3">ល.រ</th>
                                <th class="p-3">ឈ្មោះប្រភេទ</th>
                                <th class="p-3">ការពិពណ៌នា</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $index => $category)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">{{ $index + 1 }}</td>
                                    <td class="p-3 font-bold">{{ $category->name }}</td>
                                    <td class="p-3">{{ $category->description ?? 'គ្មាន' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
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

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">ឈ្មោះប្រភេទកុំព្យូទ័រ (ឧ. Laptop) *</label>
                            <input type="text" name="name"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">ការពិពណ៌នា (ជាជម្រើស)</label>
                            <textarea name="description" rows="3"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500"></textarea>
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('categories.index') }}"
                                class="px-4 py-2 text-gray-600 hover:underline mr-4">ថយក្រោយ</a>
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">
                                រក្សាទុកទិន្នន័យ
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
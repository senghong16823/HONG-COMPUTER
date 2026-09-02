<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('បញ្ចូលកុំព្យូទ័រថ្មី') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- ចំណុចសំខាន់៖ ត្រូវតែមាន enctype នេះទើប Upload រូបបាន -->
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- ឈ្មោះ និង ប្រភេទ -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">ឈ្មោះកុំព្យូទ័រ *</label>
                                <input type="text" name="name"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">ប្រភេទកុំព្យូទ័រ *</label>
                                <select name="category_id"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                                    <option value="">-- សូមជ្រើសរើសប្រភេទ --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- តម្លៃ និង ស្តុក -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">តម្លៃ (ដុល្លារ) *</label>
                                <input type="number" step="0.01" name="price"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">ចំនួនក្នុងស្តុក</label>
                                <input type="number" name="stock" value="0"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500">
                            </div>

                            <!-- លក្ខណៈបច្ចេកទេស -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">CPU</label>
                                <input type="text" name="cpu" placeholder="ឧ. Intel Core i7"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">RAM</label>
                                <input type="text" name="ram" placeholder="ឧ. 16GB"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">ទំហំផ្ទុក (Storage)</label>
                                <input type="text" name="storage" placeholder="ឧ. 512GB SSD"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500">
                            </div>

                            <!-- កន្លែង Upload រូបភាព -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">រូបភាពកុំព្យូទ័រ</label>
                                <input type="file" name="image" accept="image/*"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 p-1 border">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">ការពិពណ៌នាបន្ថែម</label>
                            <textarea name="description" rows="3"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500"></textarea>
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('products.index') }}"
                                class="px-4 py-2 text-gray-600 hover:underline mr-4">ថយក្រោយ</a>
                            <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 rounded shadow hover:bg-green-700">
                                រក្សាទុកកុំព្យូទ័រ
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
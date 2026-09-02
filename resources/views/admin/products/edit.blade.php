<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('កែប្រែព័ត៌មានកុំព្យូទ័រ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- ចំណុចសំខាន់សម្រាប់ការ Update ក្នុង Laravel -->

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">ឈ្មោះកុំព្យូទ័រ *</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">ប្រភេទកុំព្យូទ័រ *</label>
                                <select name="category_id"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">តម្លៃ (ដុល្លារ) *</label>
                                <input type="number" step="0.01" name="price"
                                    value="{{ old('price', $product->price) }}"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">ចំនួនក្នុងស្តុក</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">CPU</label>
                                <input type="text" name="cpu" value="{{ old('cpu', $product->cpu) }}"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">RAM</label>
                                <input type="text" name="ram" value="{{ old('ram', $product->ram) }}"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">ទំហំផ្ទុក (Storage)</label>
                                <input type="text" name="storage" value="{{ old('storage', $product->storage) }}"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">រូបភាពថ្មី (បើចង់ប្តូរ)</label>
                                <input type="file" name="image" accept="image/*"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 p-1 border mb-2">
                                @if($product->image)
                                    <div class="text-sm text-gray-500">រូបភាពបច្ចុប្បន្ន៖</div>
                                    <img src="{{ asset($product->image) }}"
                                        class="w-16 h-16 object-cover rounded mt-1 shadow">
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">ការពិពណ៌នាបន្ថែម</label>
                            <textarea name="description" rows="3"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('products.index') }}"
                                class="px-4 py-2 text-gray-600 hover:underline mr-4">ថយក្រោយ</a>
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">
                                រក្សាទុកការកែប្រែ
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
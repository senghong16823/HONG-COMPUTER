<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('បញ្ជីកុំព្យូទ័រទាំងអស់') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ប៊ូតុងបញ្ចូនទៅទំព័រ Form -->
            <div class="mb-4 flex justify-end">
                <a href="{{ route('products.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                    + បញ្ចូលកុំព្យូទ័រថ្មី
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <th class="p-3 text-center"></th>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-3">ល.រ</th>
                                <th class="p-3">រូបភាព</th>
                                <th class="p-3">ឈ្មោះកុំព្យូទ័រ</th>
                                <th class="p-3">ប្រភេទ</th>
                                <th class="p-3">តម្លៃ</th>
                                <th class="p-3">ស្តុក</th>
                                <th class="p-3 text-center">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $index => $product)
                            <tr class="border-b hover:bg-gray-50">
                                <!-- ១. លេខរៀង -->
                                <td class="p-3">{{ $index + 1 }}</td>

                                <!-- ២. រូបភាព -->
                                <td class="p-3">
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" alt="រូបភាពកុំព្យូទ័រ" class="w-16 h-16 object-cover rounded shadow">
                                    @else
                                        <span class="text-gray-400 text-sm">គ្មានរូបភាព</span>
                                    @endif
                                </td>

                                <!-- ៣. ព័ត៌មានផ្សេងៗ -->
                                <td class="p-3 font-bold">{{ $product->name }}</td>
                                <td class="p-3">{{ $product->category->name ?? 'មិនមាន' }}</td>
                                <td class="p-3 text-red-600 font-bold">${{ number_format($product->price, 2) }}</td>
                                <td class="p-3">{{ $product->stock }}</td>

                                <!-- ៤. ប៊ូតុងសកម្មភាព (កែប្រែ និង លុប នៅក្រោមកូនប្រឡោះដាច់ដោយឡែក) -->
                                <td class="p-3 text-center">
                                    <div class="flex justify-center items-center space-x-2">
                                        <!-- ប៊ូតុងកែប្រែ -->
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                                            កែប្រែ
                                        </a>

                                       
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            onsubmit="return confirm('តើអ្នកពិតជាចង់លុបទំនិញនេះមែនទេ?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                                លុប
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
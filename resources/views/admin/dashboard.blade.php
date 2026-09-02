<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 font-bold text-red-600">
                    សូមស្វាគមន៍ លោកគ្រូអ្នកគ្រូ! នេះគឺជាទំព័រគ្រប់គ្រងសម្រាប់ Admin។
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
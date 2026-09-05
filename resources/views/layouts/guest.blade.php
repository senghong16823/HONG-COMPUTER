<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HONG COMPUTER') }}</title>

    <!-- Google Font សម្រាប់អក្សរខ្មែរ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Kantumruy Pro', sans-serif !important;
            /* កំណត់ Background Gradient ដោយផ្ទាល់ ធានាថាចេញ ១០០% */
            background: linear-gradient(135deg, #f1f5f9 0%, #f8fafc 50%, #e0f2fe 100%) !important;
            background-attachment: fixed !important;
        }
    </style>
</head>

<body class="min-h-screen m-0 font-sans antialiased">

    <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6">

        {{-- Logo មេខាងលើ --}}
        <div class="mb-6 text-center">
            <a href="/" class="inline-flex items-center gap-3 group">
                <div
                    class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl shadow-lg shadow-blue-600/20 group-hover:scale-105 transition duration-200">
                    <i class="fa-solid fa-laptop"></i>
                </div>
                <span
                    class="text-2xl font-bold tracking-tight text-slate-800 group-hover:text-blue-600 transition duration-200">
                    HONG COMPUTER
                </span>
            </a>
        </div>

        {{-- Container ប្រអប់ Form (Light Mode Card) --}}
        <div
            class="w-full sm:max-w-md bg-white border border-slate-200/80 p-8 rounded-3xl shadow-xl shadow-slate-200/60">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <p class="mt-8 text-xs text-slate-400 text-center">
            © 2026 HONG COMPUTER. រក្សាសិទ្ធិគ្រប់យ៉ាង។
        </p>

    </div>

</body>

</html>
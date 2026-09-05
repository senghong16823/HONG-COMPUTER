<x-guest-layout>
    {{-- Header ក្នុង Form --}}
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-blue-800 mb-1">សូមស្វាគមន៍!</h1>
        <p class="text-sm text-slate-500 leading-relaxed">មកកាន់ប្រព័ន្ធគ្រប់គ្រងហាងលក់កុំព្យូទ័រ</p>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email Address --}}
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">
                អាសយដ្ឋានអ៊ីមែល <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-sm transition duration-200"
                    placeholder="admin@example.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        {{-- Password ជាមួយ Toggle Show/Hide --}}
        <div x-data="{ showPassword: false }">
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">
                លេខសម្ងាត់ <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-lock text-xs"></i>
                </div>
                <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required
                    autocomplete="current-password"
                    class="w-full pl-10 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-sm transition duration-200"
                    placeholder="••••••••">

                <button type="button" @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition duration-150 cursor-pointer">
                    <i class="fa-solid fa-eye text-sm" x-show="showPassword" x-cloak></i>
                    <i class="fa-solid fa-eye-slash text-sm" x-show="!showPassword"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me"
                class="flex items-center text-slate-600 hover:text-slate-800 cursor-pointer select-none">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20 focus:ring-2 w-4 h-4">
                <span class="ms-2 font-medium leading-normal">ចងចាំខ្ញុំ</span>
            </label>

            @if (Route::has('password.request'))
                <a class="font-medium text-blue-600 hover:text-blue-700 hover:underline leading-normal"
                    href="{{ route('password.request') }}">
                    ភ្លេចលេខសម្ងាត់?
                </a>
            @endif
        </div>

        {{-- Submit Button --}}
        <div class="pt-2">
            <button type="submit"
                class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/25 transition duration-200 text-sm cursor-pointer flex items-center justify-center gap-2">
                <span>ចូលប្រើប្រាស់</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </div>

        <div x-data="{ capsOn: false }" 
     @keydown.window="capsOn = $event.getModifierState && $event.getModifierState('CapsLock')"
     x-show="capsOn" 
     x-cloak 
     class="mt-2 text-xs text-amber-600 flex items-center gap-1.5 font-medium">
    <i class="fa-solid fa-triangle-exclamation"></i>
    <span>ប្រយ័ត្ន! Caps Lock កំពុងបើក</span>
</div>
    </form>
</x-guest-layout>
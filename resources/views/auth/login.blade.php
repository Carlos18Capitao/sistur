<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Bem-vindo de volta</h2>
        <p class="text-sm text-gray-500 mt-1">Inicie sessão na sua conta Sistur</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Google Login -->
    <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 px-6 py-3 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition shadow-sm">
        <svg class="w-5 h-5" viewBox="0 0 24 24">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Continuar com Google
    </a>

    <div class="relative my-5">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
        <div class="relative flex justify-center text-sm"><span class="bg-white px-3 text-gray-400">ou</span></div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Palavra-passe -->
        <div>
            <x-input-label for="password" value="Palavra-passe" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Lembrar-me + Esqueceu -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Lembrar-me</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-orange-500 hover:text-orange-600 font-medium" href="{{ route('password.request') }}">
                    Esqueceu a palavra-passe?
                </a>
            @endif
        </div>

        <x-primary-button>
            <i class="fas fa-sign-in-alt mr-2"></i> Entrar
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            Não tem conta?
            <a href="{{ route('register') }}" class="text-orange-500 hover:text-orange-600 font-semibold">Registar-se</a>
        </p>
    </form>
</x-guest-layout>

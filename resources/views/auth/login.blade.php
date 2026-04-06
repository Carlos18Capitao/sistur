<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Bem-vindo de volta</h2>
        <p class="text-sm text-gray-500 mt-1">Inicie sessão na sua conta Sistur</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

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

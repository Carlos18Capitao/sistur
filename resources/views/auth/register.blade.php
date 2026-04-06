<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Criar conta</h2>
        <p class="text-sm text-gray-500 mt-1">Junte-se à comunidade Sistur Angola</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Nome -->
        <div>
            <x-input-label for="name" value="Nome completo" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="O seu nome" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Palavra-passe -->
        <div>
            <x-input-label for="password" value="Palavra-passe" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirmar Palavra-passe -->
        <div>
            <x-input-label for="password_confirmation" value="Confirmar palavra-passe" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repita a palavra-passe" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <x-primary-button>
            <i class="fas fa-user-plus mr-2"></i> Registar
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            Já tem conta?
            <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-semibold">Entrar</a>
        </p>
    </form>
</x-guest-layout>

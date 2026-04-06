<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-key text-orange-500 text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Redefinir palavra-passe</h2>
        <p class="text-sm text-gray-500 mt-1">Defina a sua nova palavra-passe abaixo.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Nova Palavra-passe -->
        <div>
            <x-input-label for="password" value="Nova palavra-passe" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirmar -->
        <div>
            <x-input-label for="password_confirmation" value="Confirmar palavra-passe" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repita a palavra-passe" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <x-primary-button>
            <i class="fas fa-check mr-2"></i> Redefinir palavra-passe
        </x-primary-button>
    </form>
</x-guest-layout>

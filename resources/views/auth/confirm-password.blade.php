<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-shield-alt text-orange-500 text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Confirmar palavra-passe</h2>
        <p class="text-sm text-gray-500 mt-1">Esta é uma área segura. Por favor confirme a sua palavra-passe antes de continuar.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Palavra-passe -->
        <div>
            <x-input-label for="password" value="Palavra-passe" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <x-primary-button>
            <i class="fas fa-check-circle mr-2"></i> Confirmar
        </x-primary-button>
    </form>
</x-guest-layout>

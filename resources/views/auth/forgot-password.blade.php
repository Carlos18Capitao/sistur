<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-lock text-orange-500 text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Esqueceu a palavra-passe?</h2>
        <p class="text-sm text-gray-500 mt-1">Indique o seu email e enviaremos um link para redefinir a sua palavra-passe.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <x-primary-button>
            <i class="fas fa-paper-plane mr-2"></i> Enviar link de recuperação
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-semibold">
                <i class="fas fa-arrow-left mr-1"></i> Voltar ao login
            </a>
        </p>
    </form>
</x-guest-layout>

<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-envelope-open-text text-orange-500 text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Verificar email</h2>
        <p class="text-sm text-gray-500 mt-1">Obrigado por se registar! Verifique o seu email clicando no link que acabámos de enviar. Se não recebeu o email, podemos enviar outro.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-xl text-center">
            <i class="fas fa-check-circle mr-1"></i> Um novo link de verificação foi enviado para o seu email.
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                <i class="fas fa-redo mr-2"></i> Reenviar email de verificação
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-center text-sm text-gray-500 hover:text-orange-500 font-medium transition">
                <i class="fas fa-sign-out-alt mr-1"></i> Sair
            </button>
        </form>
    </div>
</x-guest-layout>

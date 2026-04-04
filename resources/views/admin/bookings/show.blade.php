<x-layouts.admin>
    <x-slot name="title">Reserva {{ $booking->reference }}</x-slot>

@php
    $sc = ['pendente'=>'bg-yellow-100 text-yellow-700','confirmado'=>'bg-green-100 text-green-700','cancelado'=>'bg-red-100 text-red-600','concluido'=>'bg-blue-100 text-blue-700'];
    $pc = ['pendente'=>'bg-gray-100 text-gray-600','pago'=>'bg-green-100 text-green-700','reembolsado'=>'bg-blue-100 text-blue-700'];
@endphp

<div class="mb-4">
    <a href="{{ route('admin.bookings.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
        <i class="fas fa-arrow-left mr-1"></i>Voltar às Reservas
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <p class="text-gray-400 text-sm">Referência</p>
                    <h2 class="font-mono font-bold text-xl text-gray-900">{{ $booking->reference }}</h2>
                </div>
                <div class="flex gap-2">
                    <span class="text-sm px-3 py-1 rounded-full {{ $sc[$booking->status] ?? '' }} font-semibold capitalize">{{ $booking->status }}</span>
                    <span class="text-sm px-3 py-1 rounded-full {{ $pc[$booking->payment_status] ?? '' }} font-semibold capitalize">{{ $booking->payment_status }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-gray-500">Tour</p>
                    <p class="font-semibold text-gray-900 text-sm mt-1">{{ Str::limit($booking->tour->name, 20) }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-gray-500">Data</p>
                    <p class="font-semibold text-gray-900 text-sm mt-1">{{ $booking->tour_date->format('d/m/Y') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-gray-500">Participantes</p>
                    <p class="font-semibold text-gray-900 text-sm mt-1">{{ $booking->participants }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-gray-500">Total</p>
                    <p class="font-semibold text-gray-900 text-sm mt-1">{{ number_format($booking->total_price, 2, ',', '.') }} AOA</p>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <h3 class="font-semibold text-sm text-gray-900 mb-3">Contacto do Cliente</h3>
                <div class="space-y-1.5 text-sm text-gray-600">
                    <p><i class="fas fa-user w-5 text-gray-400"></i>{{ $booking->user->name }}</p>
                    <p><i class="fas fa-envelope w-5 text-gray-400"></i>{{ $booking->contact_email }}</p>
                    @if($booking->contact_phone)
                        <p><i class="fas fa-phone w-5 text-gray-400"></i>{{ $booking->contact_phone }}</p>
                    @endif
                </div>
            </div>

            @if($booking->special_requests)
                <div class="border-t border-gray-100 pt-4 mt-4">
                    <p class="font-semibold text-sm text-gray-900 mb-1">Pedidos Especiais</p>
                    <p class="text-sm text-gray-600">{{ $booking->special_requests }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="space-y-4">
        @if($booking->isPending())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-900 mb-4">Ações</h3>
                <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}" class="mb-3">
                    @csrf
                    <button type="submit" class="w-full bg-green-500 text-white py-2.5 rounded-xl font-semibold hover:bg-green-600 transition text-sm">
                        <i class="fas fa-check mr-2"></i>Confirmar Reserva
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}"
                      x-data x-on:submit.prevent="if(confirm('Cancelar esta reserva?')) $el.submit()">
                    @csrf
                    <button type="submit" class="w-full bg-red-50 text-red-600 py-2.5 rounded-xl font-semibold hover:bg-red-100 transition text-sm">
                        <i class="fas fa-times mr-2"></i>Cancelar Reserva
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

</x-layouts.admin>

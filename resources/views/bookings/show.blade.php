<x-app-layout>
    <x-slot name="title">Reserva {{ $booking->reference }}</x-slot>

@php
    $statusColors = ['pendente'=>'bg-yellow-100 text-yellow-700','confirmado'=>'bg-green-100 text-green-700','cancelado'=>'bg-red-100 text-red-600','concluido'=>'bg-blue-100 text-blue-700'];
    $paymentColors = ['pendente'=>'bg-gray-100 text-gray-600','pago'=>'bg-green-100 text-green-700','reembolsado'=>'bg-blue-100 text-blue-700'];
@endphp

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <a href="{{ route('bookings.index') }}" class="hover:text-orange-500 transition">Minhas Reservas</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="font-medium text-gray-700">{{ $booking->reference }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-5 flex justify-between items-center">
            <div>
                <p class="text-orange-100 text-sm">Referência</p>
                <p class="text-white font-mono font-bold text-xl">{{ $booking->reference }}</p>
            </div>
            <div class="text-right">
                <span class="text-xs font-semibold bg-white/20 text-white px-3 py-1 rounded-full capitalize">{{ $booking->status }}</span>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Tour Info -->
            <div class="flex gap-4">
                <div class="w-24 h-20 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                    @if($booking->tour->cover_image)
                        <img src="{{ asset('storage/' . $booking->tour->cover_image) }}" alt="{{ $booking->tour->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                            <i class="fas fa-map-marked-alt text-white text-2xl opacity-40"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="font-bold text-gray-900 text-lg">{{ $booking->tour->name }}</h2>
                    <p class="text-gray-500 text-sm mt-1"><i class="fas fa-map-marker-alt text-orange-400 mr-1"></i>{{ $booking->tour->city }}, {{ $booking->tour->province }}</p>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <i class="fas fa-calendar text-orange-400 mb-1"></i>
                    <p class="text-xs text-gray-500">Data do Tour</p>
                    <p class="font-semibold text-gray-900 text-sm">{{ $booking->tour_date->format('d/m/Y') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <i class="fas fa-users text-orange-400 mb-1"></i>
                    <p class="text-xs text-gray-500">Participantes</p>
                    <p class="font-semibold text-gray-900 text-sm">{{ $booking->participants }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <i class="fas fa-money-bill text-orange-400 mb-1"></i>
                    <p class="text-xs text-gray-500">Total Pago</p>
                    <p class="font-semibold text-gray-900 text-sm">{{ number_format($booking->total_price, 2, ',', '.') }} AOA</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <span class="block w-full text-xs {{ $paymentColors[$booking->payment_status] ?? '' }} px-2 py-0.5 rounded-full capitalize mb-1">{{ $booking->payment_status }}</span>
                    <p class="text-xs text-gray-500">Pagamento</p>
                </div>
            </div>

            <!-- Contact -->
            <div class="border-t border-gray-100 pt-4">
                <h3 class="font-semibold text-gray-900 mb-3 text-sm">Informações de Contacto</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><i class="fas fa-envelope text-gray-400 w-5"></i>{{ $booking->contact_email }}</p>
                    @if($booking->contact_phone)
                        <p><i class="fas fa-phone text-gray-400 w-5"></i>{{ $booking->contact_phone }}</p>
                    @endif
                </div>
            </div>

            @if($booking->special_requests)
                <div class="border-t border-gray-100 pt-4">
                    <h3 class="font-semibold text-gray-900 mb-2 text-sm">Pedidos Especiais</h3>
                    <p class="text-sm text-gray-600">{{ $booking->special_requests }}</p>
                </div>
            @endif

            @if($booking->isCancelled() && $booking->cancellation_reason)
                <div class="bg-red-50 rounded-xl p-4 text-sm text-red-700">
                    <p class="font-semibold mb-1"><i class="fas fa-ban mr-2"></i>Motivo de cancelamento</p>
                    <p>{{ $booking->cancellation_reason }}</p>
                </div>
            @endif

            <!-- Actions -->
            <div class="border-t border-gray-100 pt-4 flex gap-3 flex-wrap">
                <a href="{{ route('tours.show', $booking->tour->slug) }}" class="text-sm text-orange-500 hover:text-orange-600 font-semibold transition">
                    <i class="fas fa-arrow-left mr-1"></i>Ver Tour
                </a>
                @if($booking->isPending())
                    <form method="POST" action="{{ route('bookings.cancel', $booking->reference) }}"
                          x-data x-on:submit.prevent="if(confirm('Confirma o cancelamento desta reserva?')) $el.submit()">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-semibold transition">
                            <i class="fas fa-times-circle mr-1"></i>Cancelar Reserva
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>

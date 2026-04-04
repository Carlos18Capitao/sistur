<x-layouts.admin>
    <x-slot name="title">Reservas</x-slot>

<div class="flex items-center gap-3 mb-6 flex-wrap">
    @foreach([''=>'Todas', 'pendente'=>'Pendentes', 'confirmado'=>'Confirmadas', 'cancelado'=>'Canceladas', 'concluido'=>'Concluídas'] as $val => $label)
        <a href="{{ route('admin.bookings.index', array_merge(request()->query(), ['status' => $val])) }}"
           class="px-3 py-1.5 rounded-full text-sm font-semibold transition {{ ($filters['status'] ?? '') === $val ? 'bg-orange-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-orange-300' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold">Referência</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold hidden md:table-cell">Tour</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold hidden md:table-cell">Utilizador</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold hidden lg:table-cell">Data</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold hidden lg:table-cell">Total</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold">Estado</th>
                    <th class="text-right px-5 py-3 text-gray-500 font-semibold">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php $sc = ['pendente'=>'bg-yellow-100 text-yellow-700','confirmado'=>'bg-green-100 text-green-700','cancelado'=>'bg-red-100 text-red-600','concluido'=>'bg-blue-100 text-blue-700']; @endphp
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 font-mono text-xs font-bold text-gray-700">{{ $booking->reference }}</td>
                        <td class="px-5 py-3 text-gray-700 hidden md:table-cell">{{ Str::limit($booking->tour->name, 25) }}</td>
                        <td class="px-5 py-3 text-gray-600 hidden md:table-cell">{{ $booking->user->name }}</td>
                        <td class="px-5 py-3 text-gray-600 hidden lg:table-cell">{{ $booking->tour_date->format('d/m/Y') }}</td>
                        <td class="px-5 py-3 font-semibold text-gray-900 hidden lg:table-cell">{{ number_format($booking->total_price, 2, ',', '.') }} AOA</td>
                        <td class="px-5 py-3"><span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $sc[$booking->status] ?? '' }} capitalize">{{ $booking->status }}</span></td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-orange-500 hover:text-orange-600 text-sm font-semibold transition">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400">Nenhuma reserva encontrada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $bookings->links() }}</div>
    @endif
</div>

</x-layouts.admin>

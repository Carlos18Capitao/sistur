<x-layouts.admin>
    <x-slot name="title">Tours</x-slot>

<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">{{ $tours->total() }} tour(s)</p>
    <a href="{{ route('admin.tours.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition flex items-center gap-2">
        <i class="fas fa-plus"></i>Novo Tour
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold">Tour</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold hidden md:table-cell">Cidade</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold hidden md:table-cell">Preço</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold hidden lg:table-cell">Vagas</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold">Estado</th>
                    <th class="text-right px-5 py-3 text-gray-500 font-semibold">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($tours as $tour)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                    @if($tour->cover_image)
                                        <img src="{{ asset('storage/' . $tour->cover_image) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-orange-100 flex items-center justify-center">
                                            <i class="fas fa-map text-orange-400 text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $tour->name }}</p>
                                    <p class="text-xs text-gray-400 capitalize">{{ $tour->category }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600 hidden md:table-cell">{{ $tour->city }}</td>
                        <td class="px-5 py-3 font-semibold text-gray-900 hidden md:table-cell">{{ number_format($tour->price, 2, ',', '.') }} AOA</td>
                        <td class="px-5 py-3 hidden lg:table-cell">
                            <span class="{{ $tour->available_spots > 0 ? 'text-green-600' : 'text-red-500' }} font-semibold">{{ $tour->available_spots }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $tour->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $tour->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('tours.show', $tour->slug) }}" target="_blank" class="text-gray-400 hover:text-gray-600 transition" title="Ver público">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('admin.tours.edit', $tour) }}" class="text-orange-500 hover:text-orange-600 transition" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.tours.destroy', $tour) }}"
                                      x-data x-on:submit.prevent="if(confirm('Eliminar este tour?')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">Nenhum tour encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tours->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $tours->links() }}</div>
    @endif
</div>

</x-layouts.admin>

<x-layouts.admin>
    <x-slot name="title">Avaliações</x-slot>

<div class="flex items-center gap-3 mb-6">
    @foreach(['pendente'=>'Pendentes', 'aprovado'=>'Aprovadas'] as $val => $label)
        <a href="{{ route('admin.reviews.index', ['status' => $val]) }}"
           class="px-3 py-1.5 rounded-full text-sm font-semibold transition {{ $status === $val ? 'bg-orange-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-orange-300' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="space-y-4">
    @forelse($reviews as $review)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start gap-3 flex-1">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <p class="font-semibold text-gray-900 text-sm">{{ $review->user->name }}</p>
                            <span class="text-gray-400 text-xs">→</span>
                            <p class="text-orange-600 text-sm font-medium">{{ $review->tour->name }}</p>
                        </div>
                        <div class="flex gap-0.5 mb-2">
                            @for($i=1;$i<=5;$i++)
                                <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                            @endfor
                        </div>
                        <p class="font-semibold text-gray-900 text-sm mb-1">{{ $review->title }}</p>
                        <p class="text-gray-600 text-sm">{{ $review->body }}</p>
                        <p class="text-gray-400 text-xs mt-2">{{ $review->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    @if(!$review->is_approved)
                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-3 py-1.5 rounded-xl text-xs font-semibold hover:bg-green-600 transition">
                                <i class="fas fa-check mr-1"></i>Aprovar
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                          x-data x-on:submit.prevent="if(confirm('Eliminar esta avaliação?')) $el.submit()">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-50 text-red-500 px-3 py-1.5 rounded-xl text-xs font-semibold hover:bg-red-100 transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12 text-gray-400">
            <i class="fas fa-star text-4xl mb-3 opacity-20"></i>
            <p>Nenhuma avaliação {{ $status === 'pendente' ? 'pendente' : 'aprovada' }} de momento.</p>
        </div>
    @endforelse

    @if($reviews->hasPages())
        <div class="mt-4">{{ $reviews->links() }}</div>
    @endif
</div>

</x-layouts.admin>

@php
    $categoryIcons = [
        'aventura' => 'fa-hiking',
        'cultural' => 'fa-landmark',
        'natureza' => 'fa-tree',
        'gastronomia' => 'fa-utensils',
        'praia' => 'fa-umbrella-beach',
        'safari' => 'fa-paw',
        'historico' => 'fa-monument',
    ];
    $categoryColors = [
        'aventura' => 'bg-orange-100 text-orange-600',
        'cultural' => 'bg-purple-100 text-purple-600',
        'natureza' => 'bg-green-100 text-green-600',
        'gastronomia' => 'bg-yellow-100 text-yellow-600',
        'praia' => 'bg-cyan-100 text-cyan-600',
        'safari' => 'bg-amber-100 text-amber-600',
        'historico' => 'bg-stone-100 text-stone-600',
    ];
@endphp
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
    <a href="{{ route('tours.show', $tour->slug) }}" class="block">
        <div class="relative h-52 overflow-hidden bg-gray-200">
            @if($tour->cover_image)
                <img src="{{ asset('storage/' . $tour->cover_image) }}" alt="{{ $tour->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                    <i class="fas fa-map-marked-alt text-white text-6xl opacity-40"></i>
                </div>
            @endif
            @if($tour->is_featured)
                <span class="absolute top-3 left-3 bg-orange-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                    <i class="fas fa-star mr-1"></i>Destaque
                </span>
            @endif
            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur text-gray-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                <i class="fas fa-clock mr-1 text-orange-500"></i>{{ $tour->duration_days }}d
            </span>
        </div>
    </a>

    <div class="p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="inline-flex items-center gap-1.5 text-xs font-medium {{ $categoryColors[$tour->category] ?? 'bg-gray-100 text-gray-600' }} px-2.5 py-1 rounded-full capitalize">
                <i class="fas {{ $categoryIcons[$tour->category] ?? 'fa-compass' }} text-xs"></i>
                {{ $tour->category }}
            </span>
            @if($tour->reviews_count > 0)
                <div class="flex items-center gap-1 text-sm">
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <span class="font-semibold text-gray-800">{{ number_format($tour->rating_average, 1) }}</span>
                    <span class="text-gray-400 text-xs">({{ $tour->reviews_count }})</span>
                </div>
            @endif
        </div>

        <a href="{{ route('tours.show', $tour->slug) }}">
            <h3 class="font-bold text-gray-900 mb-1 hover:text-orange-500 transition line-clamp-2">{{ $tour->name }}</h3>
        </a>

        <div class="flex items-center gap-1.5 text-gray-500 text-sm mb-3">
            <i class="fas fa-map-marker-alt text-orange-400 text-xs"></i>
            <span>{{ $tour->city }}, {{ $tour->province }}</span>
        </div>

        <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ $tour->short_description }}</p>

        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
            <div>
                <span class="text-xs text-gray-400">Preço por pessoa</span>
                <p class="text-lg font-bold text-gray-900">{{ number_format($tour->price, 2, ',', '.') }} <span class="text-sm text-gray-500 font-normal">AOA</span></p>
            </div>
            @if($tour->available_spots > 0)
                <a href="{{ route('tours.show', $tour->slug) }}"
                   class="bg-orange-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-orange-600 transition font-semibold">
                    Ver Tour
                </a>
            @else
                <span class="bg-gray-100 text-gray-400 text-sm px-4 py-2 rounded-xl font-semibold">Esgotado</span>
            @endif
        </div>
    </div>
</div>

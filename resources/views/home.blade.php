<x-app-layout>

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-orange-900 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-500/30 to-transparent"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-36 relative z-10">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-orange-500/20 text-orange-300 rounded-full px-4 py-1.5 text-sm font-medium mb-6 border border-orange-500/30">
                <i class="fas fa-map-marker-alt"></i>
                Turismo em Angola
            </div>
            <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
                Descubra a <span class="text-orange-400">Beleza</span><br>
                de Angola
            </h1>
            <p class="text-lg md:text-xl text-gray-300 mb-8 leading-relaxed">
                Explore destinos únicos de Luanda ao Namibe, aventuras no Huambo, cultura no Malanje e
                muito mais. Angola espera por si.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('tours.index') }}" class="inline-flex items-center justify-center gap-2 bg-orange-500 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-orange-600 transition text-lg">
                    <i class="fas fa-search"></i>Explorar Tours
                </a>
                @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 border border-white/30 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-white/10 transition text-lg">
                        <i class="fas fa-user-plus"></i>Criar Conta
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Stats bar -->
    <div class="border-t border-white/10 bg-black/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <p class="text-2xl font-bold text-orange-400">18</p>
                    <p class="text-xs text-gray-400 mt-0.5">Províncias</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-orange-400">50+</p>
                    <p class="text-xs text-gray-400 mt-0.5">Tours disponíveis</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-orange-400">1000+</p>
                    <p class="text-xs text-gray-400 mt-0.5">Viajantes felizes</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Bar -->
<section class="max-w-4xl mx-auto px-4 -mt-6 relative z-20">
    <form action="{{ route('tours.index') }}" method="GET"
          class="bg-white rounded-2xl shadow-xl p-4 flex flex-col md:flex-row gap-3">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" placeholder="Pesquisar tours..."
                   class="w-full pl-9 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
        </div>
        <div class="md:w-44">
            <select name="city" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm text-gray-600">
                <option value="">Todas as cidades</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}">{{ $city }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded-xl hover:bg-orange-600 transition font-semibold text-sm">
            Pesquisar
        </button>
    </form>
</section>

<!-- Featured Tours -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Tours em Destaque</h2>
            <p class="text-gray-500 mt-1">As melhores experiências turísticas em Angola</p>
        </div>
        <a href="{{ route('tours.index') }}" class="hidden md:flex items-center gap-2 text-orange-500 hover:text-orange-600 font-semibold transition">
            Ver todos <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    @if($featuredTours->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <i class="fas fa-map text-5xl mb-4 opacity-30"></i>
            <p>Nenhum tour disponível de momento.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredTours as $tour)
                @include('components.tour-card', ['tour' => $tour])
            @endforeach
        </div>
        <div class="text-center mt-10 md:hidden">
            <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-2 text-orange-500 hover:text-orange-600 font-semibold">
                Ver todos os tours <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    @endif
</section>

<!-- Destinations Section -->
<section class="bg-gray-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">Destinos Populares</h2>
            <p class="text-gray-400 mt-2">Explore Angola por cidade</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $destinations = [
                    ['city' => 'Luanda', 'icon' => 'fa-city', 'color' => 'from-orange-500 to-red-600'],
                    ['city' => 'Benguela', 'icon' => 'fa-water', 'color' => 'from-blue-500 to-cyan-600'],
                    ['city' => 'Huíla', 'icon' => 'fa-mountain', 'color' => 'from-green-500 to-teal-600'],
                    ['city' => 'Namibe', 'icon' => 'fa-campground', 'color' => 'from-yellow-500 to-orange-600'],
                    ['city' => 'Malanje', 'icon' => 'fa-water', 'color' => 'from-purple-500 to-indigo-600'],
                    ['city' => 'Huambo', 'icon' => 'fa-leaf', 'color' => 'from-emerald-500 to-green-700'],
                ];
            @endphp
            @foreach($destinations as $dest)
                <a href="{{ route('tours.index', ['city' => $dest['city']]) }}"
                   class="bg-gradient-to-br {{ $dest['color'] }} rounded-2xl p-5 text-center hover:scale-105 transition-transform cursor-pointer">
                    <i class="fas {{ $dest['icon'] }} text-3xl mb-3 opacity-90"></i>
                    <p class="font-semibold text-sm">{{ $dest['city'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Sistur -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold">Porquê Escolher o Sistur?</h2>
        <p class="text-gray-500 mt-2">A plataforma de turismo mais completa de Angola</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @php $features = [
            ['icon' => 'fa-shield-check', 'color' => 'text-green-500 bg-green-50', 'title' => 'Reservas Seguras', 'desc' => 'Todas as reservas são confirmadas e protegidas pela nossa plataforma.'],
            ['icon' => 'fa-users', 'color' => 'text-blue-500 bg-blue-50', 'title' => 'Guias Locais', 'desc' => 'Os nossos guias conhecem Angola como ninguém. Experiências autênticas.'],
            ['icon' => 'fa-headset', 'color' => 'text-orange-500 bg-orange-50', 'title' => 'Suporte 24/7', 'desc' => 'A nossa equipa está disponível para ajudar antes, durante e após a viagem.'],
        ]; @endphp
        @foreach($features as $f)
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-14 h-14 {{ $f['color'] }} rounded-2xl flex items-center justify-center mb-5">
                    <i class="fas {{ $f['icon'] }} text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold mb-2">{{ $f['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>

<!-- CTA Section -->
@guest
<section class="bg-gradient-to-r from-orange-500 to-orange-600 text-white py-20">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Pronto para explorar Angola?</h2>
        <p class="text-orange-100 mb-8 text-lg">Crie a sua conta gratuitamente e comece a reservar experiências únicas.</p>
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-orange-600 px-8 py-3.5 rounded-xl font-bold hover:bg-orange-50 transition text-lg">
            <i class="fas fa-rocket"></i>Começar agora
        </a>
    </div>
</section>
@endguest

</x-app-layout>

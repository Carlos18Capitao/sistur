<x-app-layout>
    <x-slot name="title">Tours em Angola</x-slot>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Header + Filters -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tours em Angola</h1>
            <p class="text-gray-500 mt-1">{{ $tours->total() }} tour(s) encontrado(s)</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="lg:w-64 flex-shrink-0">
            <form action="{{ route('tours.index') }}" method="GET" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-5 sticky top-24">
                <h3 class="font-bold text-gray-900 text-lg">Filtros</h3>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pesquisa</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="Nome ou descrição..."
                           class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cidade</label>
                    <select name="city" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">Todas</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ ($filters['city'] ?? '') === $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Categoria</label>
                    <select name="category" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">Todas</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ ($filters['category'] ?? '') === $cat ? 'selected' : '' }} class="capitalize">{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Preço (AOA)</label>
                    <div class="flex gap-2">
                        <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}" placeholder="Mín"
                               class="w-1/2 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}" placeholder="Máx"
                               class="w-1/2 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ordenar por</label>
                    <select name="sort" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="created_at" {{ ($filters['sort'] ?? '') === 'created_at' ? 'selected' : '' }}>Mais recentes</option>
                        <option value="price" {{ ($filters['sort'] ?? '') === 'price' ? 'selected' : '' }}>Preço</option>
                        <option value="rating_average" {{ ($filters['sort'] ?? '') === 'rating_average' ? 'selected' : '' }}>Avaliação</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-orange-500 text-white py-2.5 rounded-xl font-semibold hover:bg-orange-600 transition text-sm">
                    Aplicar Filtros
                </button>

                @if(array_filter($filters))
                    <a href="{{ route('tours.index') }}" class="block text-center text-sm text-gray-500 hover:text-gray-700 transition">
                        <i class="fas fa-times mr-1"></i>Limpar filtros
                    </a>
                @endif
            </form>
        </aside>

        <!-- Tours Grid -->
        <div class="flex-1">
            @if($tours->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
                    <i class="fas fa-search text-5xl text-gray-200 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Sem resultados</h3>
                    <p class="text-gray-400">Nenhum tour encontrado com os filtros selecionados.</p>
                    <a href="{{ route('tours.index') }}" class="mt-4 inline-block text-orange-500 hover:text-orange-600 font-semibold">Ver todos</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($tours as $tour)
                        @include('components.tour-card', ['tour' => $tour])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $tours->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

</x-app-layout>

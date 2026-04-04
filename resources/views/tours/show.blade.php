<x-app-layout>
    <x-slot name="title">{{ $tour->name }}</x-slot>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-orange-500 transition">Início</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('tours.index') }}" class="hover:text-orange-500 transition">Tours</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 font-medium">{{ $tour->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Cover Image -->
            <div class="rounded-2xl overflow-hidden h-72 md:h-96 bg-gray-200">
                @if($tour->cover_image)
                    <img src="{{ asset('storage/' . $tour->cover_image) }}" alt="{{ $tour->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                        <i class="fas fa-map-marked-alt text-white text-8xl opacity-30"></i>
                    </div>
                @endif
            </div>

            <!-- Title & Meta -->
            <div>
                <div class="flex items-center gap-3 mb-3 flex-wrap">
                    <span class="bg-orange-100 text-orange-600 text-sm font-semibold px-3 py-1 rounded-full capitalize">{{ $tour->category }}</span>
                    <span class="bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-full capitalize">{{ $tour->difficulty }}</span>
                    @if($tour->is_featured)
                        <span class="bg-yellow-100 text-yellow-600 text-sm px-3 py-1 rounded-full"><i class="fas fa-star mr-1"></i>Destaque</span>
                    @endif
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">{{ $tour->name }}</h1>
                <div class="flex flex-wrap items-center gap-5 text-gray-500 text-sm">
                    <span class="flex items-center gap-1.5"><i class="fas fa-map-marker-alt text-orange-400"></i>{{ $tour->city }}, {{ $tour->province }}</span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-clock text-orange-400"></i>{{ $tour->duration_days }} dia(s)</span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-users text-orange-400"></i>Máx. {{ $tour->max_participants }} pessoas</span>
                    @if($tour->reviews_count > 0)
                        <span class="flex items-center gap-1.5"><i class="fas fa-star text-amber-400"></i>{{ number_format($tour->rating_average, 1) }} ({{ $tour->reviews_count }} avaliações)</span>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <h2 class="text-xl font-bold mb-4 text-gray-900">Sobre este tour</h2>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $tour->description }}</p>
            </div>

            <!-- Highlights -->
            @if($tour->highlights)
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-xl font-bold mb-4 text-gray-900">Destaques</h2>
                    <ul class="space-y-2">
                        @foreach($tour->highlights as $hl)
                            <li class="flex items-start gap-2 text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                                {{ $hl }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Includes / Excludes -->
            @if($tour->includes || $tour->excludes)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($tour->includes)
                        <div class="bg-green-50 rounded-2xl p-5 border border-green-100">
                            <h3 class="font-bold text-green-800 mb-3"><i class="fas fa-plus-circle mr-2"></i>Incluído</h3>
                            <ul class="space-y-1.5">
                                @foreach($tour->includes as $item)
                                    <li class="text-sm text-green-700 flex items-start gap-2">
                                        <i class="fas fa-check mt-0.5 flex-shrink-0"></i>{{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($tour->excludes)
                        <div class="bg-red-50 rounded-2xl p-5 border border-red-100">
                            <h3 class="font-bold text-red-800 mb-3"><i class="fas fa-minus-circle mr-2"></i>Não incluído</h3>
                            <ul class="space-y-1.5">
                                @foreach($tour->excludes as $item)
                                    <li class="text-sm text-red-700 flex items-start gap-2">
                                        <i class="fas fa-times mt-0.5 flex-shrink-0"></i>{{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Reviews -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <h2 class="text-xl font-bold mb-6 text-gray-900">
                    Avaliações
                    @if($tour->reviews_count > 0)
                        <span class="text-gray-400 font-normal text-base">({{ $tour->reviews_count }})</span>
                    @endif
                </h2>

                @forelse($tour->reviews as $review)
                    <div class="border-b border-gray-100 pb-5 mb-5 last:border-0 last:mb-0 last:pb-0">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold text-sm">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">{{ $review->user->name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $review->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm mb-1">{{ $review->title }}</p>
                        <p class="text-gray-600 text-sm">{{ $review->body }}</p>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Ainda não há avaliações para este tour.</p>
                @endforelse

                <!-- Review Form -->
                @auth
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">Deixar uma avaliação</h3>
                        @if($errors->any())
                            <div class="bg-red-50 text-red-600 rounded-xl p-3 mb-4 text-sm">
                                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                            </div>
                        @endif
                        <form method="POST" action="{{ route('reviews.store') }}">
                            @csrf
                            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Classificação</label>
                                    <div class="flex gap-2" x-data="{ rating: 0 }">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only" @click="rating={{ $i }}">
                                                <i class="fas fa-star text-2xl transition"
                                                   :class="rating >= {{ $i }} ? 'text-amber-400' : 'text-gray-200'"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Título</label>
                                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Resumo da sua experiência..."
                                           class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Comentário</label>
                                    <textarea name="body" rows="4" placeholder="Conte a sua experiência..."
                                              class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none">{{ old('body') }}</textarea>
                                </div>
                                <button type="submit" class="bg-orange-500 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-orange-600 transition text-sm">
                                    Enviar Avaliação
                                </button>
                            </div>
                        </form>
                    </div>
                @endauth
            </div>

        </div>

        <!-- Booking Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <div class="mb-5">
                    <span class="text-sm text-gray-500">Preço por pessoa</span>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        {{ number_format($tour->price, 2, ',', '.') }} <span class="text-base text-gray-500 font-normal">AOA</span>
                    </p>
                </div>

                <div class="space-y-2 mb-5 text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Duração</span>
                        <span class="font-semibold">{{ $tour->duration_days }} dia(s)</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Vagas disponíveis</span>
                        <span class="font-semibold {{ $tour->available_spots > 0 ? 'text-green-600' : 'text-red-500' }}">
                            {{ $tour->available_spots > 0 ? $tour->available_spots . ' vagas' : 'Esgotado' }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Dificuldade</span>
                        <span class="font-semibold capitalize">{{ $tour->difficulty }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-500">Localização</span>
                        <span class="font-semibold text-right">{{ $tour->city }}</span>
                    </div>
                </div>

                @if($tour->available_spots > 0)
                    @auth
                        <form method="POST" action="{{ route('bookings.store') }}" x-data="{ participants: 1, price: {{ $tour->price }} }">
                            @csrf
                            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                            <input type="hidden" name="contact_email" value="{{ auth()->user()->email }}">
                            <input type="hidden" name="contact_phone" value="{{ auth()->user()->phone }}">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Data do tour</label>
                                    <input type="date" name="tour_date" min="{{ date('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Participantes</label>
                                    <input type="number" name="participants" x-model="participants"
                                           min="1" max="{{ min($tour->available_spots, 20) }}" value="1"
                                           class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pedidos especiais</label>
                                    <textarea name="special_requests" rows="2" placeholder="Ex: dieta vegetariana, necessidades especiais..."
                                              class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none"></textarea>
                                </div>

                                <div class="bg-orange-50 rounded-xl p-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Total</span>
                                        <span class="font-bold text-orange-600" x-text="(participants * price).toLocaleString('pt-PT', {minimumFractionDigits: 2}) + ' AOA'"></span>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-xl font-bold hover:bg-orange-600 transition">
                                    <i class="fas fa-calendar-check mr-2"></i>Reservar Agora
                                </button>
                            </div>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-orange-500 text-white py-3 rounded-xl font-bold hover:bg-orange-600 transition text-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>Entrar para Reservar
                        </a>
                        <p class="mt-3 text-center text-sm text-gray-500">
                            Não tem conta? <a href="{{ route('register') }}" class="text-orange-500 hover:underline font-semibold">Registar</a>
                        </p>
                    @endauth
                @else
                    <div class="bg-gray-100 rounded-xl p-4 text-center text-gray-500 text-sm">
                        <i class="fas fa-ban text-2xl mb-2 block opacity-40"></i>
                        Tour esgotado. Adicione-se à lista de espera em breve.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

</x-app-layout>

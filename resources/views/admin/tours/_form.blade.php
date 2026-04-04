@props(['tour' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm">
            <p class="font-semibold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Erros de validação:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Nome -->
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nome do Tour *</label>
            <input type="text" name="name" value="{{ old('name', $tour?->name) }}" required
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Descrição curta -->
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Descrição Curta * <span class="text-gray-400 font-normal">(máx 500 caracteres)</span></label>
            <textarea name="short_description" rows="2" required
                      class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none">{{ old('short_description', $tour?->short_description) }}</textarea>
        </div>

        <!-- Descrição completa -->
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Descrição Completa *</label>
            <textarea name="description" rows="6" required
                      class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none">{{ old('description', $tour?->description) }}</textarea>
        </div>

        <!-- Cidade -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Cidade *</label>
            <input type="text" name="city" value="{{ old('city', $tour?->city) }}" required
                   placeholder="Ex: Luanda"
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Província -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Província *</label>
            <select name="province" required class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option value="">Selecionar...</option>
                @foreach($provinces as $province)
                    <option value="{{ $province }}" {{ old('province', $tour?->province) === $province ? 'selected' : '' }}>{{ $province }}</option>
                @endforeach
            </select>
        </div>

        <!-- Localização -->
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Localização / Ponto de encontro</label>
            <input type="text" name="location" value="{{ old('location', $tour?->location) }}"
                   placeholder="Ex: Museu Nacional de Angola, Luanda"
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Preço -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Preço por pessoa (AOA) *</label>
            <input type="number" name="price" value="{{ old('price', $tour?->price) }}" min="0" step="0.01" required
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Duração -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Duração (dias) *</label>
            <input type="number" name="duration_days" value="{{ old('duration_days', $tour?->duration_days) }}" min="1" required
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Max participantes -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Máx. Participantes *</label>
            <input type="number" name="max_participants" value="{{ old('max_participants', $tour?->max_participants) }}" min="1" required
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Vagas disponíveis -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Vagas Disponíveis *</label>
            <input type="number" name="available_spots" value="{{ old('available_spots', $tour?->available_spots) }}" min="0" required
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Categoria -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Categoria *</label>
            <select name="category" required class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category', $tour?->category) === $cat ? 'selected' : '' }} class="capitalize">{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Dificuldade -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Dificuldade *</label>
            <select name="difficulty" required class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                @foreach($difficulties as $diff)
                    <option value="{{ $diff }}" {{ old('difficulty', $tour?->difficulty) === $diff ? 'selected' : '' }} class="capitalize">{{ ucfirst($diff) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Available from/until -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Disponível de</label>
            <input type="date" name="available_from" value="{{ old('available_from', $tour?->available_from?->format('Y-m-d')) }}"
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Disponível até</label>
            <input type="date" name="available_until" value="{{ old('available_until', $tour?->available_until?->format('Y-m-d')) }}"
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Imagem de capa -->
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Imagem de Capa</label>
            @if($tour?->cover_image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $tour->cover_image) }}" alt="Capa atual" class="h-28 w-48 object-cover rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-400 mt-1">Imagem atual (fazer upload para substituir)</p>
                </div>
            @endif
            <input type="file" name="cover_image" accept="image/*"
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            <p class="text-xs text-gray-400 mt-1">JPEG, PNG ou WebP. Máx 2MB.</p>
        </div>

        <!-- Inclui / Não inclui / Destaques (JSON array entrada) -->
        <div class="md:col-span-2" x-data="{ items: {{ json_encode(old('highlights', $tour?->highlights ?? [])) }} }">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Destaques</label>
            <div class="space-y-2">
                <template x-for="(item, i) in items" :key="i">
                    <div class="flex gap-2">
                        <input type="text" :name="`highlights[${i}]`" x-model="items[i]"
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <button type="button" @click="items.splice(i, 1)" class="text-red-400 hover:text-red-600 px-2"><i class="fas fa-times"></i></button>
                    </div>
                </template>
                <button type="button" @click="items.push('')" class="text-orange-500 text-sm hover:text-orange-600 font-semibold">
                    <i class="fas fa-plus mr-1"></i>Adicionar destaque
                </button>
            </div>
        </div>

        <div class="md:col-span-2" x-data="{ items: {{ json_encode(old('includes', $tour?->includes ?? [])) }} }">
            <label class="block text-sm font-semibold text-gray-700 mb-1">O que está incluído</label>
            <div class="space-y-2">
                <template x-for="(item, i) in items" :key="i">
                    <div class="flex gap-2">
                        <input type="text" :name="`includes[${i}]`" x-model="items[i]"
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <button type="button" @click="items.splice(i, 1)" class="text-red-400 hover:text-red-600 px-2"><i class="fas fa-times"></i></button>
                    </div>
                </template>
                <button type="button" @click="items.push('')" class="text-green-600 text-sm hover:text-green-700 font-semibold">
                    <i class="fas fa-plus mr-1"></i>Adicionar item
                </button>
            </div>
        </div>

        <div class="md:col-span-2" x-data="{ items: {{ json_encode(old('excludes', $tour?->excludes ?? [])) }} }">
            <label class="block text-sm font-semibold text-gray-700 mb-1">O que não está incluído</label>
            <div class="space-y-2">
                <template x-for="(item, i) in items" :key="i">
                    <div class="flex gap-2">
                        <input type="text" :name="`excludes[${i}]`" x-model="items[i]"
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <button type="button" @click="items.splice(i, 1)" class="text-red-400 hover:text-red-600 px-2"><i class="fas fa-times"></i></button>
                    </div>
                </template>
                <button type="button" @click="items.push('')" class="text-red-500 text-sm hover:text-red-600 font-semibold">
                    <i class="fas fa-plus mr-1"></i>Adicionar item
                </button>
            </div>
        </div>

        <!-- Flags -->
        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $tour?->is_active ?? true) ? 'checked' : '' }}
                       class="w-4 h-4 text-orange-500 rounded focus:ring-orange-500">
                <span class="text-sm font-semibold text-gray-700">Tour ativo</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $tour?->is_featured) ? 'checked' : '' }}
                       class="w-4 h-4 text-orange-500 rounded focus:ring-orange-500">
                <span class="text-sm font-semibold text-gray-700">Em destaque</span>
            </label>
        </div>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="bg-orange-500 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-orange-600 transition text-sm">
            <i class="fas fa-save mr-2"></i>{{ $tour ? 'Guardar Alterações' : 'Criar Tour' }}
        </button>
        <a href="{{ route('admin.tours.index') }}" class="px-6 py-2.5 rounded-xl font-semibold text-sm text-gray-600 border border-gray-200 hover:bg-gray-50 transition">Cancelar</a>
    </div>
</form>

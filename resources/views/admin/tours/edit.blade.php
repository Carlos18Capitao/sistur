<x-layouts.admin>
    <x-slot name="title">Editar Tour</x-slot>

<div class="mb-4">
    <a href="{{ route('admin.tours.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
        <i class="fas fa-arrow-left mr-1"></i>Voltar aos Tours
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    @include('admin.tours._form', [
        'tour' => $tour,
        'action' => route('admin.tours.update', $tour),
        'method' => 'PUT',
    ])
</div>

</x-layouts.admin>

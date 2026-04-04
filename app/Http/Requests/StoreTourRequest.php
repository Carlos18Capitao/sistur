<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'description'       => ['required', 'string'],
            'short_description' => ['required', 'string', 'max:500'],
            'city'              => ['required', 'string', 'max:100'],
            'province'          => ['required', 'string', 'max:100'],
            'location'          => ['nullable', 'string', 'max:255'],
            'price'             => ['required', 'numeric', 'min:0'],
            'duration_days'     => ['required', 'integer', 'min:1'],
            'max_participants'  => ['required', 'integer', 'min:1'],
            'available_spots'   => ['required', 'integer', 'min:0'],
            'category'          => ['required', 'in:aventura,cultural,natureza,gastronomia,praia,safari,historico'],
            'difficulty'        => ['required', 'in:facil,moderado,dificil'],
            'cover_image'       => ['nullable', 'image', 'max:2048'],
            'is_active'         => ['boolean'],
            'is_featured'       => ['boolean'],
            'available_from'    => ['nullable', 'date'],
            'available_until'   => ['nullable', 'date', 'after_or_equal:available_from'],
            'includes'          => ['nullable', 'array'],
            'excludes'          => ['nullable', 'array'],
            'highlights'        => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'             => 'O nome do tour é obrigatório.',
            'description.required'      => 'A descrição é obrigatória.',
            'short_description.required' => 'A descrição curta é obrigatória.',
            'city.required'             => 'A cidade é obrigatória.',
            'province.required'         => 'A província é obrigatória.',
            'price.required'            => 'O preço é obrigatório.',
            'price.numeric'             => 'O preço deve ser um valor numérico.',
            'category.in'               => 'Categoria inválida.',
            'difficulty.in'             => 'Dificuldade inválida.',
            'cover_image.image'         => 'O ficheiro deve ser uma imagem.',
            'cover_image.max'           => 'A imagem não deve exceder 2MB.',
        ];
    }
}

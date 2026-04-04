<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'tour_id'    => ['required', 'integer', 'exists:tours,id'],
            'booking_id' => ['nullable', 'integer', 'exists:bookings,id'],
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            'title'      => ['required', 'string', 'max:150'],
            'body'       => ['required', 'string', 'min:20', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'A avaliação é obrigatória.',
            'rating.min'      => 'A avaliação mínima é 1 estrela.',
            'rating.max'      => 'A avaliação máxima é 5 estrelas.',
            'title.required'  => 'O título é obrigatório.',
            'body.required'   => 'O comentário é obrigatório.',
            'body.min'        => 'O comentário deve ter pelo menos 20 caracteres.',
        ];
    }
}

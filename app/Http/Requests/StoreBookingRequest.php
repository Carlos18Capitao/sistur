<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'tour_id'          => ['required', 'integer', 'exists:tours,id'],
            'tour_date'        => ['required', 'date', 'after_or_equal:today'],
            'participants'     => ['required', 'integer', 'min:1', 'max:20'],
            'contact_email'    => ['required', 'email', 'max:255'],
            'contact_phone'    => ['nullable', 'string', 'max:30'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'tour_id.required'      => 'O tour é obrigatório.',
            'tour_id.exists'        => 'Tour não encontrado.',
            'tour_date.required'    => 'A data do tour é obrigatória.',
            'tour_date.after_or_equal' => 'A data do tour deve ser a partir de hoje.',
            'participants.required' => 'O número de participantes é obrigatório.',
            'participants.min'      => 'Deve haver pelo menos 1 participante.',
            'participants.max'      => 'Máximo de 20 participantes por reserva.',
            'contact_email.required' => 'O email de contacto é obrigatório.',
            'contact_email.email'   => 'Introduza um email válido.',
        ];
    }
}

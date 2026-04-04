<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTourRequest extends StoreTourRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'cover_image' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}

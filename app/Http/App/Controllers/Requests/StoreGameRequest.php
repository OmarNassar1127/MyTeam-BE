<?php

namespace App\Http\App\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'opponent' => 'required|string',
            'home' => 'required|boolean',
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
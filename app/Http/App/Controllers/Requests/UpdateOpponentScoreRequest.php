<?php

namespace App\Http\App\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOpponentScoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'opponent_score' => 'required|integer',
        ];
    }
}
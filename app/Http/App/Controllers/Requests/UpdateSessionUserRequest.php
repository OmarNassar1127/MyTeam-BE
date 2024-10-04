<?php

namespace App\Http\App\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSessionUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'players' => 'required|array',
            'players.*' => 'required|array:user_id,status',
            'players.*.user_id' => 'required|exists:users,id',
            'players.*.status' => 'required|in:present,absent,late,cancelled',
        ];
    }
}
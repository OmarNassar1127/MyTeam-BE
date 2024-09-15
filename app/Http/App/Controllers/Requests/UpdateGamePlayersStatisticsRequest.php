<?php

namespace App\Http\App\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGamePlayersStatisticsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'players' => 'required|array',
            'players.*' => 'required|array:user_id,goals,assists,yellow_cards,red_cards',
            'players.*.user_id' => 'required|exists:users,id',
            'players.*.goals' => 'required|integer|min:0',
            'players.*.assists' => 'required|integer|min:0',
            'players.*.yellow_cards' => 'required|integer|min:0',
            'players.*.red_cards' => 'required|integer|min:0',
        ];
    }
}
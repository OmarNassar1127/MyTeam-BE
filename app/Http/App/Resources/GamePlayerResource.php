<?php

namespace App\Http\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GamePlayerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_manager' => $this->pivot->is_manager,
            'status' => $this->pivot->status,
            'goals' => $this->pivot->goals,
            'assists' => $this->pivot->assists,
            'yellow_cards' => $this->pivot->yellow_cards,
            'red_cards' => $this->pivot->red_cards,
        ];
    }
}
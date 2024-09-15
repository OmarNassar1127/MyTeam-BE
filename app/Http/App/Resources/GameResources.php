<?php

namespace App\Http\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'team_id' => $this->team_id,
            'date' => $this->date,
            'opponent' => $this->opponent,
            'home' => $this->home ? 'Thuis' : 'Uit',
            'result' => $this->result,
            'location' => $this->location,
            'notes' => $this->notes,
            'season' => $this->season,
            'players' => $this->whenLoaded('users', function () {
                return GamePlayerResource::collection($this->users);
            }),
        ];
    }
}

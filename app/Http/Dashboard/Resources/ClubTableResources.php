<?php

namespace App\Http\Dashboard\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClubTableResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'teams' => $this->teams->count(),
            'managers' => $this->teams->flatMap->managers->count(),
            'players' => $this->teams->flatMap->players->count(),
            'logo_url' => $this->getFirstMediaUrl('club_logos', 'thumb')
        ];
    }
}

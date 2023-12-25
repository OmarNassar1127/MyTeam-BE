<?php

namespace App\Http\Dashboard\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamTableResources extends JsonResource
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
            'club' => $this->club->name,
            'club_id' => $this->club_id,
            'managers' => $this->managers->count(),
            'players' => $this->players->count(),
        ];
    }
}

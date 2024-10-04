<?php

namespace App\Http\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionResources extends JsonResource
{
  public function toArray($request)
  {
      return [
          'id' => $this->id,
          'team_id' => $this->team_id,
          'date' => $this->date,
          'notes' => $this->notes,
          'completed' => $this->completed ? 'Ja' : 'Nee',
          'players' => $this->whenLoaded('users', function () {
                return SessionPlayerResource::collection($this->users);
            }),
      ];
  }
}

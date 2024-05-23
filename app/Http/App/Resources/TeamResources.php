<?php

namespace App\Http\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResources extends JsonResource
{
  public function toArray($request)
  {
      return [
          'id' => $this->id,
          'club_id' => $this->club_id,
          'name' => $this->name,
          'category' => $this->category,
      ];
  }
}

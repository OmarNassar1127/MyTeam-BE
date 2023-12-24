<?php

namespace App\Http\Dashboard\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRolesResources extends JsonResource
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
            'role' => $this->roles->first()->name,
          ];
    }
}

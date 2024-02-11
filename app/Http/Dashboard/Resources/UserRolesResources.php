<?php

namespace App\Http\Dashboard\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Role; // Add the missing import statement for the Role model
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
            'name' => $this->first_name . ' ' . $this->last_name,
            'role' => $this->roles->first() ? $this->roles->first()->name : 'User has no role',
        ];
    }
}

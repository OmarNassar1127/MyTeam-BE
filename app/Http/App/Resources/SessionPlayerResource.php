<?php

namespace App\Http\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionPlayerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->pivot->status,
        ];
    }
}
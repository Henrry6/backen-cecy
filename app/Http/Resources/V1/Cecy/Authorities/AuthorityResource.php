<?php

namespace App\Http\Resources\V1\Cecy\Authorities;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Core\Users\FullnameResource;

class AuthorityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => FullnameResource::make($this->user),
            'electronicSignature' => $this->electronicSignature,
            'positionStartedAt' => $this->position_started_at,
            'positionEndedAt' => $this->position_ended_at
        ];
    }
}

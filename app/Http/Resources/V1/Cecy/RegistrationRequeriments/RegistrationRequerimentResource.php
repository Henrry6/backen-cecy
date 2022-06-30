<?php

namespace App\Http\Resources\V1\Cecy\RegistrationRequeriments;

use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Http\Resources\V1\Cecy\Requeriments\RequirementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationRequerimentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            // 'registration'=> RegistrationResource::make($this->registration),
            // 'requirement'=> RequirementResource::make($this->requirement),
            'url' => $this->url,
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Cecy\RegistrationRequeriments;

use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Http\Resources\V1\Cecy\Requeriments\RequerimentResource;
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
            // 'registration'=> RegistrationResource::make($this->registration_id),
            // 'requirement'=> RequerimentResource::make($this->requirement_id),
            'url' => $this->url,
        ];
    }
}

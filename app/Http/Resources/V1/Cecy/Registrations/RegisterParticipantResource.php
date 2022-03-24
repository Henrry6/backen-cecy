<?php

namespace App\Http\Resources\V1\Cecy\Registrations;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Cecy\Participant;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;

class RegisterParticipantResource extends JsonResource
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
        
        'id' => $this->id,
        'personTypeId' => ParticipantResource::make($this->person_type_id),
        

        ];
    }
}

<?php

namespace App\Http\Resources\V1\Cecy\Planifications\PlanificationParticipants;


use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Re

class PlanificationParticipantResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'participant' => ParticipantResource::make($this->participant),
            
        ];
    }
}

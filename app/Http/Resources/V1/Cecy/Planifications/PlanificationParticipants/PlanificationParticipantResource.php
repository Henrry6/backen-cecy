<?php

namespace App\Http\Resources\V1\Cecy\Planifications\PlanificationParticipants;

use App\Http\Resources\V1\Cecy\AdditionalInformations\AdditionalInformationResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
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
            'aditionalInformation' => AdditionalInformationResource::make($this->additionalInformation),
            'state' => CatalogueResource::make($this->state),
            'stateCourse' => CatalogueResource::make($this->stateCourse),
            'type' => CatalogueResource::make($this->type),
            'typeParticipant' => CatalogueResource::make($this->typeParticipant),
            'number' => $this->number,
            'observations' => $this->observations,       
        ];
    }
}

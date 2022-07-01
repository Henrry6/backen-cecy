<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationParticipants;

use App\Http\Resources\V1\Cecy\AdditionalInformations\AdditionalInformationResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Certificates\CertificateResource;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
use App\Http\Resources\V1\Cecy\RegistrationRequeriments\RegistrationRequerimentResource;
use App\Http\Resources\V1\Cecy\Requeriments\RequirementResource;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Re

class DetailPlanificationParticipantResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'participant' => ParticipantResource::make($this->participant),
            'requirements'=> $this->requirements,
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
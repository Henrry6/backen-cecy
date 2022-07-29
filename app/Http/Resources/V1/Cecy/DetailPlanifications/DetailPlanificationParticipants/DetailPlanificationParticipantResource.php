<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationParticipants;

use App\Http\Requests\V1\Cecy\DetailPlanifications\DetailPlanificationRequest;
use App\Http\Resources\V1\Cecy\AdditionalInformations\AdditionalInformationResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Certificates\CertificateResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\ResponsibleCourseDetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
use App\Http\Resources\V1\Cecy\RegistrationRequeriments\RegistrationRequerimentResource;
use App\Http\Resources\V1\Cecy\Requeriments\RequirementResource;
use App\Models\Cecy\DetailPlanification;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Re

class DetailPlanificationParticipantResource extends JsonResource
{
    public function toArray($request)
    {
        $observaciones=(is_string($this->observations)||is_null($this->observations))?array(""):$this->observations;
        $lastObservation=end($observaciones);
        return [
            'id' => $this->id,
            'participant' => ParticipantResource::make($this->participant),            
            'requirements'=> $this->requirements,
            'aditionalInformation' => AdditionalInformationResource::make($this->additionalInformation),
            'detailPlanification' => DetailPlanificationResource::make($this->detailPlanification),
            'state' => CatalogueResource::make($this->state),
            'stateCourse' => CatalogueResource::make($this->stateCourse),
            'type' => CatalogueResource::make($this->type),
            'typeParticipant' => CatalogueResource::make($this->typeParticipant),
            'number' => $this->number,
            'observations' => $lastObservation,
        ];
    }
}

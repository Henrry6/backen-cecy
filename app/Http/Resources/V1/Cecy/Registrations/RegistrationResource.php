<?php

namespace App\Http\Resources\V1\Cecy\Registrations;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailPlanification;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $observaciones=(is_string($this->observations)||is_null($this->observations))?array(""):$this->observations;
        $lastObservation=end($observaciones);
        return [
            'id' => $this->id,
//            'detailPlanification' => DetailPlanificationResource::make($this->detailPlanification),
            'participant' => ParticipantResource::make($this->participant),
            'state' => CatalogueResource::make($this->state),
            'stateCourse' => CatalogueResource::make($this->stateCourse),
            'type' => CatalogueResource::make($this->type),
            'typeParticipant' => CatalogueResource::make($this->typeParticipant),
            'finalGrade' => $this->final_grade,
            'grade1' => $this->grade1,
            'grade2' => $this->grade2,
            'number' => $this->number,
            'observations' => $lastObservation,
            'registeredAt' => $this->registered_at
        ];
    }
}

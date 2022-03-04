<?php

namespace App\Http\Resources\V1\Cecy\Participants;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationInverseResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesByParticipantResource extends JsonResource
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
            'detailPlanification' => DetailPlanificationInverseResource::make($this->detailPlanification),
            'participant' => ParticipantResource::make($this->participant),
            'state.id' => CatalogueResource::make($this->state),
            'stateCourse' => CatalogueResource::make($this->stateCourse),
            'type' => CatalogueResource::make($this->type),
            'typeParticipant' => CatalogueResource::make($this->typeParticipant),
            'finalGrade' => $this->final_grade,
            'grade1' => $this->grade1,
            'grade2' => $this->grade2,
            'number' => $this->number,
            'observations' => $this->observations,
            'registeredAt' => $this->registered_at

        ];
    }
}

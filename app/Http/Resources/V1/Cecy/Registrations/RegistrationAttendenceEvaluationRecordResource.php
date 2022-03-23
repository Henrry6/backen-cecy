<?php

namespace App\Http\Resources\V1\Cecy\Registrations;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationAttendenceEvaluationRecordResource extends JsonResource
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
            'detailPlanification' => DetailPlanificationInformNeedResource::collection($this->detail_planification),
            'participant' => ParticipantRecordCompetitorResource::collection($this->participant),
            'state' => CatalogueResource::make($this->state)

        ];
    }
}

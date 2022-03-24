<?php

namespace App\Http\Resources\V1\Cecy\Registrations;

use App\Http\Requests\V1\Cecy\Registrations\RegisterStudentRequest;
use App\Http\Resources\V1\Cecy\AdditionalInformations\AdditionalInformationResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
use App\Http\Resources\V1\Core\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterStudentResource extends JsonResource
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
            'levelInstruction' => CatalogueResource::make($this->levelInstruction),
            'number' => $this->number,
            'participant' => ParticipantResource::make($this->participant),
            'registeredAt' => $this->registered_at,
            'state' =>CatalogueResource::make($this->state),
            'type' =>CatalogueResource::make($this->type),
        //    'typeParticipant' => CatalogueResource::make($this->typeParticipant),
        //    'additionalInformation' => AdditionalInformationResource::make($this->additionalInformation),
        ];
    }
}

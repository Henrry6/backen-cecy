<?php

namespace App\Http\Resources\V1\Cecy\Participants;

use App\Http\Resources\V1\Cecy\AdditionalInformations\AdditionalInformationResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Core\Users\UserResource;
use App\Models\Cecy\Participant;

class ParticipantInformationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'additionalInformation' => AdditionalInformationResource::make($this->additionalInformation),
            // 'participant' => ParticipantResource::make($this->participant),
            // 'state' => CatalogueResource::make($this->state),
        ];
    }
}

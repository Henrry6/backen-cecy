<?php

namespace App\Http\Resources\V1\Cecy\Participants;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Core\Users\UserResource;


class ParticipantInformationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'additionalInformation' => CatalogueResource::make($this->personType),
            'user' => UserResource::make($this->user),
            'state' => CatalogueResource::make($this->state),
        ];
    }
}
<?php

namespace App\Http\Resources\V1\Cecy\Registrations;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ParticipantRegistrationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Cecy\Planifications\PlanificationParticipants;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlanificationParticipantCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

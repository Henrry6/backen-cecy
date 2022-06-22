<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationParticipants;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DetailPlanificationParticipantCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

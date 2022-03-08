<?php

namespace App\Http\Resources\V1\Cecy\DetailAttendances;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DetailAttendanceParticipantsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Cecy\Attendances;

use Illuminate\Http\Resources\Json\JsonResource;

class GetAttendanceByParticipantResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
        ];
    }
}

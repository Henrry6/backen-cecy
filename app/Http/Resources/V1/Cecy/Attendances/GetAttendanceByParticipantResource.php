<?php

namespace App\Http\Resources\V1\Cecy\Attendances;

use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceResource;
use Illuminate\Http\Resources\Json\JsonResource;


class GetAttendanceByParticipantResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'detailAttendance' => DetailAttendanceResource::make($this->detailAttendance),
            'duration' => $this->duration,
            'registeredAt' => $this->registered_at,
        ];
    }
}

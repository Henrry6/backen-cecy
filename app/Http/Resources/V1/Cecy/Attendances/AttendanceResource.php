<?php

namespace App\Http\Resources\V1\Cecy\Attendances;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceParticipantsResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;

class AttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'detailAttendances' => DetailAttendanceParticipantsResource::collection($this->detailAttendances),
            'detailPlanification' => DetailPlanificationResource::make($this->detailPlanification),
            'duration' => $this->duration,
            'registeredAt' => $this->registered_at,
        ];
    }
}

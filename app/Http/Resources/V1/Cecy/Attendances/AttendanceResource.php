<?php

namespace App\Http\Resources\V1\Cecy\Attendances;

use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceDateResource;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceParticipantsResource;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'detailPlanification' => DetailPlanificationResource::make($this->detailPlanification),
            'detailAttendances' => DetailAttendanceParticipantsResource::collection($this->detailAttendances),
            'duration' => $this->duration,
            'registeredAt' => $this->registered_at,
        ];
    }
}

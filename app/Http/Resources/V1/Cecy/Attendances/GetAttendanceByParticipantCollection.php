<?php

namespace App\Http\Resources\V1\Cecy\Attendances;

use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAttendanceByParticipantCollection extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'detailPlanification' => DetailPlanificationResource::make($this->detailPlanification),
            'duration' => $this->duration,
            'registeredAt' => $this->registered_at,
        ];
    }
}
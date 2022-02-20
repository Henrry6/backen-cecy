<?php

namespace App\Http\Resources\V1\Cecy\DetailSchoolPeriods;


use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodResource;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Re

class DetailSchoolPeriodResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'schoolPeriod' => SchoolPeriodResource::make($this->schoolPeriod),
            'especialEndedAt' => $this->especial_ended_at,
            'especialStartedAt' => $this->especial_started_at,
            'extraordinaryEndedAt' => $this->extraordinary_ended_at,
            'extraordinaryStartedAt' => $this->extraordinary_started_at,
            'nullificationEndedAt' => $this->nullification_ended_at,
            'nullificationStartedAt' => $this->nullification_started_at,
            'ordinaryEndedAt' => $this->ordinary_ended_at,
            'ordinaryStartedAt' => $this->ordinary_started_at,
        ];
    }
}

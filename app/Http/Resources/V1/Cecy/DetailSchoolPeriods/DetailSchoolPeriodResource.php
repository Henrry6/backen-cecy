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
            'schoolPeriod' => SchoolPeriodResource::make($this->detailSchoolPeriods),
            'especialEndedAt' => $this->especialEndedAt,
            'especialStartedAt' => $this->especialStartedAt,
            'extraordinaryEndedAt' => $this->extraordinaryEndedAt,
            'extraordinaryStartedAt' => $this->extraordinaryStartedAt,
            'nullificationEndedAt' => $this->nullificationEndedAt,
            'nullificationStartedAt' => $this->nullificationStartedAt,
            'ordinaryEndedAt' => $this->ordinaryEndedAt,
            'ordinaryStartedAt' => $this->ordinaryStartedAt,
        ];
    }
}

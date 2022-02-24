<?php

namespace App\Http\Resources\V1\Cecy\DetailSchoolPeriods;


use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodResource;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodShortResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailSchoolPeriodShortResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'schoolPeriod' => SchoolPeriodShortResource::make($this->schoolPeriod),
        ];
    }
}

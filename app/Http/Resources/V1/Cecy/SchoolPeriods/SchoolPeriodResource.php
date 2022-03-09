<?php

namespace App\Http\Resources\V1\Cecy\SchoolPeriods;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolPeriodResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code'=> $this->code,
            'endedAt'=> $this->ended_at,
            'name'=> $this->name,
            'startedAt'=> $this->started_at,
            'minimumNote' => $this->minimum_note,
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanifications;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\DetailInstructors\DetailInstructorResource;

class DetailPlanificationPhotographicRecordResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'workday' => CatalogueResource::make($this->workday),
            // 'planificacion' => PlanificationInformNeedResource::collection($this->planification),
            'endTime' => $this->end_time,
            'startTime' => $this->start_time,
        ];
    }
}

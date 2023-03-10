<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanifications;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\DetailInstructors\DetailInstructorResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationsInformNeedResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailPlanificationInformNeedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'day' => CatalogueResource::make($this->day),
            'planificacion' => PlanificationsInformNeedResource::make($this->planification),
            'endTime' => $this->end_time,
            'startTime' => $this->start_time,
            // 'classroom' => ClassroomInformNeedResource::make($this->classroom)
        ];
    }
}

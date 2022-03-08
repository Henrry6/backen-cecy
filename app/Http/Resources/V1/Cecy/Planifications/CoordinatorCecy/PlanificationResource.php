<?php

namespace App\Http\Resources\V1\Cecy\Planifications\CoordinatorCecy;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\DetailSchoolPeriods\DetailSchoolPeriodResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorFullnameResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'detailSchoolPeriod' => DetailSchoolPeriodResource::make($this->detailSchoolPeriod),
            'responsibleCourse' => InstructorFullnameResource::make($this->responsibleCourse),
            'state' => CatalogueResource::make($this->state),
            'detailPlanifications' => DetailPlanificationResource::collection($this->detailPlanifications),
            'aprovedAt' => $this->aproved_at,
            'endedAt' => $this->ended_at,
            'observations' => $this->observations,
            'startedAt' => $this->started_at,
        ];
    }
}

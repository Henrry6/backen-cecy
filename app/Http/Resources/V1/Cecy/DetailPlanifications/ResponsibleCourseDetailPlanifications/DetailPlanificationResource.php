<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanifications\ResponsibleCourseDetailPlanifications;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Classrooms\ClassroomResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorFullnameResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationShortResource;

class DetailPlanificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'classroom' => ClassroomResource::make($this->classroom),
            'day' => CatalogueResource::make($this->day),
            'instructors' => InstructorFullnameResource::collection($this->instructors),
            'planification' => PlanificationShortResource::make($this->planification),
            'parallel' => CatalogueResource::make($this->parallel),
            'state' => CatalogueResource::make($this->state),
            'workday' => CatalogueResource::make($this->workday),
            'endedTime' => $this->ended_time,
            'observations' => $this->observations,
            'startedTime' => $this->started_time,
            'schedule' => $this->getScheduleAttribute(),
        ];
    }
}

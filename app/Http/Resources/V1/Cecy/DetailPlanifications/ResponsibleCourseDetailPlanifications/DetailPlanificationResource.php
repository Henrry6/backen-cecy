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
            'parallel' => CatalogueResource::make($this->parallel),
            'planification' => PlanificationShortResource::make($this->planification),
            'state' => CatalogueResource::make($this->state),
            'workday' => CatalogueResource::make($this->workday),
            'endedTime' => $this->ended_time,
            'instructors' => InstructorFullnameResource::collection($this->instructors),
            'observations' => $this->observations,
            'schedule' => $this->started_time . '-' . $this->ended_time,
            'startedTime' => $this->started_time,
        ];
    }
}

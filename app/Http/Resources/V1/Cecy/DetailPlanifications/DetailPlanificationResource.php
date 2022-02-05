<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanifications;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Classrooms\ClassroomResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Models\Cecy\Classroom;
use App\Models\Cecy\Registration;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailPlanificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => CourseResource::make($this->course),
            'day' => CatalogueResource::make($this->day),
            'classroom' => ClassroomResource::make($this->classroom),
            'parallel' => CatalogueResource::make($this->parallel),
            'planification' => PlanificationResource::make($this->planification),
            // 'workday' => CatalogueResource::make($this->workday),
            // 'state' => CatalogueResource::make($this->state),
            // 'registrations' => RegistrationResource::collection($this->registrations),
            // 'endedTime' => $this->ended_time,
            // 'observations' => $this->observations,
            // 'planEndedAt' => $this->plan_ended_at,
            // 'registrationsLeft' => $this->registrations_left,
            // 'startedTime' => $this->started_time
        ];
    }
}

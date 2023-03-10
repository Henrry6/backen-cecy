<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanifications;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Classrooms\ClassroomResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Models\Cecy\Classroom;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Registration;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailPlanificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'classroom' => ClassroomResource::make($this->classroom),
            'day' => CatalogueResource::make($this->day),
            'instructors' => InstructorResource::collection($this->instructors),
            'parallel' => CatalogueResource::make($this->parallel),
            'registrations' => RegistrationResource::collection($this->registrations),
            'state' => CatalogueResource::make($this->state),
            'workday' => CatalogueResource::make($this->workday),
            'endedTime' => $this->ended_time,
            'observations' => $this->observations,
            'planEndedAt' => $this->plan_ended_at,
            'capacity' => $this->capacity,
            'startedTime' => $this->started_time,
        ];
    }
}

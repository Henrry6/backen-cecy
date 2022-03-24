<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanifications;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Classrooms\ClassroomResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationInverseResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Models\Cecy\Classroom;
use App\Models\Cecy\Registration;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailPlanificationInverseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'classroom' => ClassroomResource::make($this->classroom),
            'day' => CatalogueResource::make($this->day),
            'planification' => PlanificationInverseResource::make($this->planification),
            'parallel' => CatalogueResource::make($this->parallel),
            'registrationsLeft' => $this->registrations_left,
            'state' => CatalogueResource::make($this->state),
            'workday' => CatalogueResource::make($this->workday),
            'endedTime' => $this->ended_time,
            'observations' => $this->observations,
            'planEndedAt' => $this->plan_ended_at,
            'startedTime' => $this->started_time
        ];
    }
}

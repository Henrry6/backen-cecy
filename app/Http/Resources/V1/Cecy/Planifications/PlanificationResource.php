<?php

namespace App\Http\Resources\V1\Cecy\Planifications;

use App\Http\Resources\V1\Cecy\Authorities\AuthorityResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationCollection;
use App\Http\Resources\V1\Cecy\DetailSchoolPeriods\DetailSchoolPeriodResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Models\Cecy\DetailPlanification;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Re

class PlanificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => CourseResource::make($this->course),
            'detailSchoolPeriod' => DetailSchoolPeriodResource::make($this->detailSchoolPeriod),
            'responsibleCourse' => InstructorResource::make($this->responsibleCourse),
            'responsibleCecy' => AuthorityResource::make($this->responsibleCecy),
            'responsibleOcs' => AuthorityResource::make($this->responsibleOcs),
            'state' => CatalogueResource::make($this->state),
            'vicerector' => AuthorityResource::make($this->vicerector),
            'detailPlanifications' => DetailPlanificationCollection::collection($this->detailPlanifications),
            'aprovedAt' => $this->aproved_at,
            'code' => $this->code,
            'endedAt' => $this->ended_at,
            'needs' => $this->needs,
            'observations' => $this->observations,
            // 'startedAt' => Carbon::createFromFormat('Y-m-d', $this->started_at),
            'startedAt' => $this->started_at,
        ];
    }
}

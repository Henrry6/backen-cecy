<?php

namespace App\Http\Resources\V1\Cecy\Planifications;

use App\Http\Resources\V1\Cecy\Authorities\AuthorityResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\DetailSchoolPeriods\DetailSchoolPeriodResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Models\Cecy\DetailPlanification;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Re

class PlanificationsResponsibleCecyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => CourseResource::make($this->course),
            'responsibleCecy' => AuthorityResource::make($this->responsibleCecy),
            'detailPlanifications' => DetailPlanificationResource::collection($this->detailPlanifications),
        ];
    }
}

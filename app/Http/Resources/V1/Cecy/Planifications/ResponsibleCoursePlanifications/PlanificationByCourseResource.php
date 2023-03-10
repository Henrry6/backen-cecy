<?php

namespace App\Http\Resources\V1\Cecy\Planifications\ResponsibleCoursePlanifications;

use App\Http\Resources\V1\Cecy\Authorities\AuthorityResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueCollection;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Courses\BasicCourseResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\ResponsibleCourseDetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\ResponsibleCourseDetailPlanifications\InstructorsOfPlanificationResource;
use App\Http\Resources\V1\Cecy\DetailSchoolPeriods\DetailSchoolPeriodResource;
use App\Http\Resources\V1\Cecy\DetailSchoolPeriods\DetailSchoolPeriodShortResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorFullnameResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodResource;
use App\Models\Cecy\Instructor;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanificationByCourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => BasicCourseResource::make($this->course),
            'detailPlanifications' => InstructorsOfPlanificationResource::collection($this->detailPlanifications),
            'detailSchoolPeriod' => DetailSchoolPeriodShortResource::make($this->detailSchoolPeriod),
            'responsibleCecy' => AuthorityResource::make($this->responsibleCecy),
            'responsibleCourse' => InstructorFullnameResource::make($this->responsibleCourse),
            'state' => CatalogueResource::make($this->state),
            'code' => $this->code,
            'endedAt' => $this->ended_at,
            'needs' => $this->needs,
            'observations' => $this->observations,
            'startedAt' => $this->started_at,
        ];
    }
}

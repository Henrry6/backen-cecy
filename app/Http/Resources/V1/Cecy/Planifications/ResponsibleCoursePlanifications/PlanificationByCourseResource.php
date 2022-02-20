<?php

namespace App\Http\Resources\V1\Cecy\Planifications\ResponsibleCoursePlanifications;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueCollection;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\DetailSchoolPeriods\DetailSchoolPeriodResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodResource;
use App\Models\Cecy\Instructor;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanificationByCourseResource extends JsonResource
{
    public function toArray($request)
    {
        $course = $request->input('course.id');
        // $partipantTypes = $course->participantType();
        
        return [
            'id' => $this->id,
            'detailPlanifications' => DetailPlanificationResource::collection($this->detailPlanifications),
            // 'participantTypes' => new CatalogueCollection($partipantTypes),
            'responsibleCourse' => InstructorResource::make($this->responsibleCourse),
            // 'schoolPeriod' => DetailSchoolPeriodResource::collection($this->detailSchoolPeriod),
            'state' => CatalogueResource::make($this->state),
            'code' => $this->code,
            'endedAt' => $this->ended_at,
            'startedAt' => $this->started_at,
        ];
    }
}

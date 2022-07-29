<?php

namespace App\Http\Resources\V1\Cecy\Planifications;

use App\Http\Resources\V1\Cecy\AnnualOperativePlans\AnnualOperativePlanResource;
use App\Http\Resources\V1\Cecy\Authorities\AuthorityResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\DetailSchoolPeriods\DetailSchoolPeriodResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Models\Cecy\DetailPlanification;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Re

class PlanificationByAuthorityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => CourseResource::make($this->course),
            'detailPlanifications' => DetailPlanificationResource::collection($this->detailPlanifications),
            'period'=>DetailSchoolPeriodResource::make($this->detailSchoolPeriod)->schoolPeriod,
        ];
    }
}

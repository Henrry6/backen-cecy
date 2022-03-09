<?php

namespace App\Http\Resources\V1\Cecy\Courses\CoordinatorCecy;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Cecy\Planifications\CoordinatorCecy\PlanificationResource;
use App\Http\Resources\V1\Core\CareerResource;
use App\Models\Cecy\Planification;
use App\Models\Cecy\SchoolPeriod;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseByCoordinatorCecyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'academicPeriod' => CatalogueResource::make($this->academicPeriod),
            'planifications' => PlanificationResource::collection($this->planifications),
            'state' => CatalogueResource::make($this->state),
            'approvedAt' => $this->approved_at,
            'bibliographies' => $this->bibliographies,
            'career' => CareerResource::make($this->career),
            'code' => $this->code,
            'name' => $this->name,
        ];
    }
}

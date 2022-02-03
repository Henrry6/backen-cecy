<?php

namespace App\Http\Resources\V1\Cecy\Courses;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Core\CareerResource;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\Planification;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseParallelWorkdayResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parallel' => CatalogueResource::make($this->parallel),
            'workday' => CatalogueResource::make($this->workday),
            'course' => Course::make($this->course),
            'planification' => Planification::make($this->planification),           
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanifications\ResponsibleCourseDetailPlanifications;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Classrooms\ClassroomResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorFullnameResource;

class InstructorsOfPlanificationResource extends JsonResource
{
    public function toArray($request)
    {
        $instructors = InstructorFullnameResource::collection($this->instructors);

        return [
            'id' => $this->id,
            'instructors' => $instructors,
        ];
    }
}

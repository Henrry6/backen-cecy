<?php

namespace App\Http\Resources\V1\Cecy\ParticipantCourse;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Core\Users\UserResource;
use App\Models\Cecy\Course;

class ParticipantCourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => CourseResource::collection($this->catalogues),
            'participantType' => CatalogueResource::collection($this->courses),
        ];
    }
}

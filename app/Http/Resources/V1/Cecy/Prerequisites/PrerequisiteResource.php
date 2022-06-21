<?php

namespace App\Http\Resources\V1\Cecy\Prerequisites;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Courses\CoursePrerequisiteResource;

class PrerequisiteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => CoursePrerequisiteResource::make($this->course),
            'prerequisite' => CoursePrerequisiteResource::make($this->prerequisite),
        ];
    }
}

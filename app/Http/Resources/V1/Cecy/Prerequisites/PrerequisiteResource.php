<?php

namespace App\Http\Resources\V1\Cecy\Prerequisites;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Courses\BasicCourseResource;

class PrerequisiteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => BasicCourseResource::make($this->course),
            'prerequisite' => BasicCourseResource::make($this->prerequisite),
        ];
    }
}

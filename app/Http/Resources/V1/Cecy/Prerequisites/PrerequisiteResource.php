<?php

namespace App\Http\Resources\V1\Cecy\Prerequisites;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResourceBasic;

class PrerequisiteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => CourseResourceBasic::make($this->course),
            'prerequisite' => CourseResourceBasic::make($this->prerequisite),
        ];
    }
}

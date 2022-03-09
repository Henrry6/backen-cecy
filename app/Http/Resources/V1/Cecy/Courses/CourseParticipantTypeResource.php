<?php

namespace App\Http\Resources\V1\Cecy\Courses;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseParticipantTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Cecy\ParticipantCourse;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ParticipantCourseCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

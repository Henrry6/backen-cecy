<?php

namespace App\Http\Resources\V1\Cecy\CourseProfiles;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseProfileCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

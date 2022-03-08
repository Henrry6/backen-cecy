<?php

namespace App\Http\Resources\V1\Cecy\Courses\CoordinatorCecy;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseByCoordinatorCecyCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

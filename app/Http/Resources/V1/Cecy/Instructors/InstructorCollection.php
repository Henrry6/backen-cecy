<?php

namespace App\Http\Resources\V1\Cecy\Instructors;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DetailPlanificationInstructorCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

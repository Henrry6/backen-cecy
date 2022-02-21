<?php

namespace App\Http\Resources\V1\Cecy\Planifications\ResponsibleCoursePlanifications;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ResponsibleCoursePlanificationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

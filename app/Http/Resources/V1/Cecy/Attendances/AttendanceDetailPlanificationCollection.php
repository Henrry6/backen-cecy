<?php

namespace App\Http\Resources\V1\Cecy\Attendances;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AttendanceDetailPlanificationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

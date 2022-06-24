<?php

namespace App\Http\Resources\V1\Cecy\DetailAttendances;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DetailAttendanceByAttendanceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

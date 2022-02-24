<?php

namespace App\Http\Resources\V1\Cecy\SchoolPeriods;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SchoolPeriodCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

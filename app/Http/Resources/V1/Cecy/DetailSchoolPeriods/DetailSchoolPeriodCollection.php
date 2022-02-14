<?php

namespace App\Http\Resources\V1\Cecy\DetailSchoolPeriods;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DetailSchoolPeriodCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}

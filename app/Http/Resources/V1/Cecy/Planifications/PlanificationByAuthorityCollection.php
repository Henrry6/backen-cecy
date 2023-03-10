<?php

namespace App\Http\Resources\V1\Cecy\Planifications;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlanificationByAuthorityCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}

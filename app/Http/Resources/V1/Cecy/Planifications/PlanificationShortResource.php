<?php

namespace App\Http\Resources\V1\Cecy\Planifications;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanificationShortResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id
        ];
    }
}

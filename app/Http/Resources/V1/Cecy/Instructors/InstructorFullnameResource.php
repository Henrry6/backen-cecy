<?php

namespace App\Http\Resources\V1\Cecy\Instructors;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Core\Users\FullnameResource;

class InstructorFullnameResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => FullnameResource::make($this->user),
        ];
    }
}

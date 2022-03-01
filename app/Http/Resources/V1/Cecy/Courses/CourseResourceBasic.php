<?php

namespace App\Http\Resources\V1\Cecy\Courses;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResourceBasic extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'summary' => $this->summary,
            'participantTypes' => CatalogueResource::collection($this->catalogues)
        ];
    }
}

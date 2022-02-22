<?php

namespace App\Http\Resources\V1\Cecy\Topics;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResourceBasic;

class TopicResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => CourseResourceBasic::make($this->course),
            // 'parent' => TopicResource::make($this->parent),
            'children' => TopicResource::collection($this->children),
            'level' => $this->level,
            'description' => $this->description,
        ];
    }
}

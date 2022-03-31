<?php

namespace App\Http\Resources\V1\Cecy\Topics;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Cecy\Courses\BasicCourseResource;

class TopicResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => BasicCourseResource::make($this->course),
            // 'parent' => TopicResource::make($this->parent),
            'children' => TopicResource::collection($this->children),
            'description' => $this->description,
            'level' => $this->level,
        ];
    }
}

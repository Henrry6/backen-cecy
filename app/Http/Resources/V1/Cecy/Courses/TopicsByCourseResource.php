<?php

namespace App\Http\Resources\V1\Cecy\Courses;

use App\Http\Resources\V1\Cecy\Topics\TopicResource;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\Topic;
use Illuminate\Http\Resources\Json\JsonResource;

class TopicsByCourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course.id' => CourseResource::make($this->course),
            'level' => $this->level,
            'parent.id' => TopicResource::make($this->children),
            'description' => $this->description
        ];
    }
}

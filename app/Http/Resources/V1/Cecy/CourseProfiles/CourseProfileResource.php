<?php

namespace App\Http\Resources\V1\Cecy\CourseProfiles;

use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => CourseCollection::make($this->course),
            'requiredExperiences' => $this->require_experience,
            'requiredKnowledges' => $this->require_knowledge,
            'requiredSkills' => $this->require_skills
        ];
    }
}

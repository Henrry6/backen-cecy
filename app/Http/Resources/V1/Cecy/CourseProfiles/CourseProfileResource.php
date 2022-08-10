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
//            'course' => CourseCollection::make($this->course),
            'requiredExperiences' => $this->required_experiences,
            'requiredKnowledges' => $this->required_knowledges,
            'requiredSkills' => $this->required_skills
        ];
    }
}

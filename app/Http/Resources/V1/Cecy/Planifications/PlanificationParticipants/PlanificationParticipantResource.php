<?php

namespace App\Http\Resources\V1\Cecy\Planifications;

use App\Http\Resources\V1\Cecy\Authorities\AuthorityResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodResource;
use App\Models\Cecy\Participant;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Re

class PlanificationParticipantResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'participant' => ParticipantResource::make($this->participant),
            
        ];
    }
}

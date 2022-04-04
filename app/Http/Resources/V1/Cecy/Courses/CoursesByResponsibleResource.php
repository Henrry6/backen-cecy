<?php

namespace App\Http\Resources\V1\Cecy\Courses;

use App\Http\Resources\V1\Cecy\Authorities\AuthorityResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorFullnameResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
use App\Http\Resources\V1\Cecy\Planifications\CoordinatorCecy\PlanificationResource;
use App\Http\Resources\V1\Cecy\Planifications\ResponsibleCoursePlanifications\PlanificationByResponsibleCourseResource;
use App\Http\Resources\V1\Core\CareerResource;
use App\Http\Resources\V1\Core\ImageResource;
use App\Models\Cecy\Authority;
use App\Models\Cecy\SchoolPeriod;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesByResponsibleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'career' => CareerResource::make($this->career),
            'certifiedType' => CatalogueResource::make($this->certifiedType),
            'category' => CatalogueResource::make($this->category),
            'courseType' => CatalogueResource::make($this->courseType),
            'entityCertification' => CatalogueResource::make($this->entityCertification),
            'formationType' => CatalogueResource::make($this->formationType),
            'image' => ImageResource::make($this->image),
            'modality' => CatalogueResource::make($this->modality),
            'participantTypes' => CatalogueResource::collection($this->catalogues),
            'planifications' => PlanificationByResponsibleCourseResource::collection($this->planifications),
            'responsible' => InstructorFullnameResource::make($this->responsible),
            'state' => CatalogueResource::make($this->state),
            'abbreviation' => $this->abbreviation,
            'code' => $this->code,
            'duration' => $this->duration,
            'name' => $this->name,
            'needs' => $this->needs,
            'project' => $this->project,
            'summary' => $this->summary,
            'targetGroups' => $this->target_groups,
        ];
    }
}

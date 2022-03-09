<?php

namespace App\Http\Resources\V1\Cecy\Courses;

use App\Http\Resources\V1\Cecy\Authorities\AuthorityResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
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
            'name' => $this->name,
            'entityCertification' => CatalogueResource::make($this->entityCertification),
            'career' => CareerResource::make($this->career),
            'category' => CatalogueResource::make($this->category),
            'formationType' => CatalogueResource::make($this->formationType),
            'images' => ImageResource::collection($this->images),
            'certifiedType' => CatalogueResource::make($this->certifiedType),
            'courseType' => CatalogueResource::make($this->courseType),
            'modality' => CatalogueResource::make($this->modality),
            'state' => CatalogueResource::make($this->state),
            'abbreviation' => $this->abbreviation,
            'code' => $this->code,
            'duration' => $this->duration,
            'participantTypes' => CatalogueResource::collection($this->catalogues),
            'needs' => $this->needs,
            'project' => $this->project,
            'summary' => $this->summary,
            'targetGroups' => $this->target_groups,
        ];
    }
}

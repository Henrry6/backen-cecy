<?php

namespace App\Http\Resources\V1\Cecy\Courses;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\CourseProfiles\CourseProfileResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationResource;
use App\Http\Resources\V1\Core\CareerResource;
use App\Http\Resources\V1\Core\ImageResource;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\CourseProfile;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Instructor;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'career' => CareerResource::make($this->career),
            'state' => CatalogueResource::make($this->state),
            'code' => $this->code,
            'duration' => $this->duration,
            'name' => $this->name,
            'profilecourse'=> CourseProfileResource::make($this->courseProfile),
            'instructor'=> InstructorResource::collection(CourseProfile::where('id',$this->id)->first()->instructors()->get()), //yo comente esta linea porque da error en el metodo show de curso  de la api, verificar si esta bien escrita
        ];
    }
}

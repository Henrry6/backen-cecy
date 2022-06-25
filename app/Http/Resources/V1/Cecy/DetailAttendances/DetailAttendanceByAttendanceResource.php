<?php

namespace App\Http\Resources\V1\Cecy\DetailAttendances;

use App\Http\Resources\V1\Cecy\Attendances\AttendanceResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Core\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailAttendanceByAttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'attendance' => AttendanceResource::make($this->attendance),
            'user' => UserResource::make($this->registration->participant->user),
            'participant' => UserResource::make($this->registration->participant),
            'type' => CatalogueResource::make($this->type)
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Cecy\DetailAttendances;

use App\Http\Resources\V1\Cecy\Attendances\AttendanceResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailAttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'attendance' => AttendanceResource::make($this->attendance),
            'registration' => RegistrationResource::make($this->registration),
            'type' => CatalogueResource::make($this->type)
        ];
    }
}

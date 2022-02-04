<?php

namespace App\Http\Resources\V1\Cecy\Registrations;

use App\Http\Requests\V1\Cecy\Registrations\RegisterStudentRequest;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Core\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'number' => $this->number,
            'registeredAt' => $this->registered_at,
            'participant' => UserResource::make($this->username),
            'type' =>CatalogueResource::make($this->type),
            'state' =>CatalogueResource::make($this->state),
            'levelInstruction' => CatalogueResource::make($this->levelInstruction),
            'registration' => RegistrationResource::make($this->registration),
            'typeParticipant' => CatalogueResource::make($this->typeParticipant),
            'companyName' => $this->company_name,
            'companyActivity' => $this->company_activity,
            'companyAddress' => $this->company_address,
            'companyEmail' => $this->company_email,
            'companyPhone' => $this->company_phone,
            'companySponsored' => $this->company_sponsored,
            'contactName' => $this->contact_name,
            'courseFollows' => $this->course_follows,
            'courseKnows' => $this->course_knows,
            'worked' => $this->worked,
        ];
    }
}

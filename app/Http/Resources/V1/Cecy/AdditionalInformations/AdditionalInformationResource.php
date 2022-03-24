<?php

namespace App\Http\Resources\V1\Cecy\AdditionalInformations;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Models\Cecy\Registration;
use Illuminate\Http\Resources\Json\JsonResource;

class AdditionalInformationResource extends JsonResource
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
            'id' => $this->id,
            'companyActivity' => $this->company_activity,
            'companyAddress' => $this->company_address,
            'companyEmail' => $this->company_email,
            'companyName' => $this->company_name,
            'contactName' => $this->contact_name,
            'companyPhone' => $this->company_phone,
            'companySponsored' => $this->company_sponsored,
            'courseFollows' => $this->course_follows,
            'courseKnows' => $this->course_knows,
            'worked' => $this->worked,
            'levelInstruction' => CatalogueResource::make($this->levelInstruction),
            'registration' => RegistrationResource::make($this->registration),
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Cecy\Registrations;

use App\Http\Resources\V1\Cecy\AdditionalInformations\AdditionalInformationResource;
use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Certificates\CertificateResource;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
use App\Http\Resources\V1\Cecy\RegistrationRequeriments\RegistrationRequerimentResource;
use App\Http\Resources\V1\Cecy\Requeriments\RequerimentResource;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Re

class ParticipantRegistrationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->participant->user->email,
            'lastname' => $this->participant->user->lastname,
            'name' => $this->participant->user->name,
            'username' => $this->participant->user->username,
            'instruction' => $this->additionalInformation->levelInstruction->name,
            'companyName' => $this->additionalInformation->company_name,
            'companySponsored' => $this->additionalInformation->company_sponsored,
            'companyAddress' => $this->additionalInformation->company_address,
            'companyActivity' => $this->additionalInformation->company_activity,
            'observations' => $this->observations,
            'requirements'=> $this->requirements,
            'detailPlanificationId' => $this->detailPlanification->id,
            'registrationState' => $this->state->name,
        ];
    }
}

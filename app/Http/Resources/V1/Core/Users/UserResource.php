<?php

namespace App\Http\Resources\V1\Core\Users;

use App\Http\Resources\V1\Core\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Core\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Core\EmailResource;
use App\Http\Resources\V1\Core\ImageResource;
use App\Http\Resources\V1\Core\LocationResource;
use App\Http\Resources\V1\Core\PhoneResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar,
            'username' => $this->username,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'birthdate' => $this->birthdate,
            'emails' => EmailResource::collection($this->emails),
            'phones' => PhoneResource::collection($this->phones),
            'images' => ImageResource::collection($this->images),
            'identificationType' => CatalogueResource::make($this->identificationType),
            'nationality' => LocationResource::make($this->nationality),
            'sex' => CatalogueResource::make($this->sex),
            'adress' => AddressResource::make($this->address),
            'bloodType' => CatalogueResource::make($this->bloodType),
            'bloodType' => CatalogueResource::make($this->bloodType),
            'ethnicOrigin' => CatalogueResource::make($this->ethnicOrigin),
            'civilStatus' => CatalogueResource::make($this->civilStatus),
            'disability' => CatalogueResource::make($this->disability),
            'emailVerifiedAt' => $this->email_verified_at,
            'passwordChanged' => $this->password_changed,
            'updatedAt' => $this->updated_at,
        ];
    }
}

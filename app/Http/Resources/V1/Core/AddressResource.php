<?php

namespace App\Http\Resources\V1\Core;

use App\Http\Resources\V1\Core\Catalogues\CatalogueResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'latitude' => $this->latitud,
            'longitude' => $this->longitude,
            'main_street' => $this->main_street,
            'secondaryStreet' => $this->secondary_street,
            'number' => $this->number,
            'postCode' => $this->post_code,
            'reference' => $this->reference,
            'location' => LocationResource::make($this->location),
            'sector' => CatalogueResource::make($this->sector)
        ];
    }
}

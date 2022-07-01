<?php

namespace App\Http\Resources\V1\Cecy\AnnualOperativePlans;

use App\Http\Resources\V1\Cecy\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Models\Cecy\Registration;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnualOperativePlanResource extends JsonResource
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
      
            'tradeNumber'=>$this->trade_number,
            'year'=>$this->year,
            'officialDateAt'=>$this->official_date_at,
            'activities'=>$this->activities
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Core\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class FullnameResource extends JsonResource
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
            'fullname' => $this->name . "" . $this->lastname,
        ];
    }
}

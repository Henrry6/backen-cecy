<?php

namespace App\Http\Resources\V1\Cecy\Catalogues;

use Illuminate\Http\Resources\Json\JsonResource;

class CatalogueResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'parent' => CatalogueResource::make($this->parent),
            'code' => $this->code,
            'description' => $this->description,
            'icon' => $this->icon,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}

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
            'children' => CatalogueResource::collection($this->children),
            'code' => $this->code,
            'description' => $this->description,
            'icon' => $this->icon,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}

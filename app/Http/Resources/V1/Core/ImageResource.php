<?php

namespace App\Http\Resources\V1\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'extension' => $this->extension,
            'fullName' => "{$this->name}.{$this->extension}",
            'fullPathOriginal' => "images/{$this->id}/{$this->id}.jpg",
            'fullPathWebp' => "images/{$this->id}/{$this->id}.webp",
            'fullPathLgWebp' => "images/{$this->id}/{$this->id}-lg.webp",
            'fullPathLgJpg' => "images/{$this->id}/{$this->id}-lg.jpg",
            'fullPathMdWebp' => "images/{$this->id}/{$this->id}-md.webp",
            'fullPathMdJpg' => "images/{$this->id}/{$this->id}-md.jpg",
            'fullPathSMWebp' => "images/{$this->id}/{$this->id}-sm.webp",
            'fullPathSMJpg' => "images/{$this->id}/{$this->id}-sm.jpg",
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Cecy\PhotographicRecords;

use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotographicRecordResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'detailPlanification' => DetailPlanificationResource::make($this->detailPlanification),
            'description' => $this->description,
            'numberWeek'=>$this->number_week,
            'urlImage'=> $this->url_image,
            'weekAt' =>$this->week_at,

        ];
    }
}

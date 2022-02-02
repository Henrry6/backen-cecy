<?php

namespace App\Http\Resources\V1\Cecy\Participants;

use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesByParticipantResource extends JsonResource
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
            'detailPlanificationResource' => DetailPlanificationResource::make($this->detailPlanificationResource),
            'name' => $this->name,
            'code' => $this->code,
            'grade1' => $this->grade1,
            'grade2' => $this->grade2,
            'final_grade' => $this->final_grade,
            'approvedAt' => $this->approved_at,

        ];
    }
}

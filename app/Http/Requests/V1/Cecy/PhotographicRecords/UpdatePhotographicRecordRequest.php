<?php

namespace App\Http\Requests\V1\Cecy\PhotographicRecords;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotographicRecordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'detailPlanification.id' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'numberWeek' => ['required', 'integer'],
//            'urlImage' => ['required','string'],
            'weekAt' => ['required','date'],

        ];
    }

    public function attributes()
    {
        return [
            'detailPlanification.id' => 'Id detalle de la planificacion',
            'description' => 'descripción',
            'numberWeek' => 'numero de semanas',
//            'urlImage' => 'url de la imagen',
            'weekAt' => 'fecha',
        ];
    }
}


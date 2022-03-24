<?php

namespace App\Http\Requests\V1\Cecy\SchoolPeriods;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolPeriodRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'state.id' =>  ['integer', 'required'],
            'code' =>  ['required'],
            'endedAt' =>  ['required'],
            'minimumNote' =>  ['required'],
            'name' =>  ['required'],
            'startedAt' =>  ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'state.id' =>  'Id del estado del periodo lectivo',
            'code' =>  'código único del periodo lectivo',
            'endedAt' =>  'Fecha de finalización del periodo lectivo',
            'minimumNote' =>  'mínimo de nota para aprobar los cursos',
            'name' =>  'nombre del periodo lectivo',
            'startedAt' =>  'Fecha de inicio del periodo lectivo',
        ];
    }
}

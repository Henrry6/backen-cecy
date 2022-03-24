<?php

namespace App\Http\Requests\V1\Cecy\SchoolPeriods;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolPeriodRequest extends FormRequest
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
            'ended_at' =>  ['required'],
            'minimum_note' =>  ['required'],
            'name' =>  ['required'],
            'started_at' =>  ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'state.id' =>  'Id del estado del periodo lectivo',
            'code' =>  'código único del periodo lectivo',
            'ended_at' =>  'Fecha de finalización del periodo lectivo',
            'minimum_note' =>  'mínimo de nota para aprobar los cursos',
            'name' =>  'nombre del periodo lectivo',
            'started_at' =>  'Fecha de inicio del periodo lectivo',
        ];
    }
}

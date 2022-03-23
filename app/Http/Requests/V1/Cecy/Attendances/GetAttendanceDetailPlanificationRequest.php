<?php

namespace App\Http\Requests\V1\Cecy\Attendances;

use Illuminate\Foundation\Http\FormRequest;

class GetAttendanceDetailPlanificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'planification.id' =>  ['integer', 'required'],
            'startTime' =>  ['integer', 'required'],
            'endTime' =>  ['integer', 'required'],
        ];
    }

    public function attributes()
    {
        return [
            'planification.id' => 'id de la planificacion',
            'startTime' => 'hora de inicio del curso',
            'endTime' => 'hora de cierre del curso',
        ];
    }
}

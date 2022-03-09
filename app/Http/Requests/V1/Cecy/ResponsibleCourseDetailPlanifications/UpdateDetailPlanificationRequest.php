<?php

namespace App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailPlanificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'classroom.id' => ['required', 'integer'],
            'day.id' => ['required', 'integer'],
            'planification.id' => ['required', 'integer'],
            'workday.id' => ['required', 'integer'],
            'parallel.id' => ['required', 'integer'],
            'endedTime' => ['required', 'after:startedTime'],
            'startedTime' => ['required',],
            'observations' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'classroom.id' => 'Aula',
            'day.id' => 'Días de clase',
            'planification.id' => 'Planificación',
            'workday.id' => 'Jornada',
            'paralel.id' => 'Paralelo del aula o clase',
            'endedTime' => 'Hora de inicio',
            'startedTime' => 'Hora de fin',
        ];
    }
}

<?php

namespace App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\HoursRule;
use App\Rules\WorkdayRule;

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
            'parallel.id' => [
                'required', 'integer',
            ],
            'workday.id' => ['required', 'integer'],
            'planification.id' => [
                'required', 'integer',
            ],
            'endedTime' => ['required', 'after:startedTime'],
            'startedTime' => ['required',],
        ];
    }

    public function attributes()
    {
        return [
            'classroom.id' => 'aula',
            'day.id' => 'días de clase',
            'parallel.id' => 'paralelo del aula',
            'planification.id' => 'planificación',
            'workday.id' => 'jornada',
            'endedTime' => 'hora de fin',
            'startedTime' => 'hora de inicio',
        ];
    }
}

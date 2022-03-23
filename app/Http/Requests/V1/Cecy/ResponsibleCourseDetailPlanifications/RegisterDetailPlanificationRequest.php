<?php

namespace App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications;

use App\Rules\StoreParallelRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Workday;
use App\Rules\WorkdayRule;

class RegisterDetailPlanificationRequest extends FormRequest
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
            'workday.id' => ['required', 'integer', new WorkdayRule($this->endedTime)],
            'parallel.id' => ['required', 'integer'],
            'endedTime' => ['required', 'after:startedTime'],
            'startedTime' => ['required',],
            'observations' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'classroom.id' => 'aula',
            'day.id' => 'días de clase',
            'planification.id' => 'planificación',
            'workday.id' => 'jornada',
            'paralel.id' => 'paralelo del aula o clase',
            'endedTime' => 'hora de inicio',
            'startedTime' => 'hora de fin',
        ];
    }
}

<?php

namespace App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UpdateParallelRule;
use App\Rules\WorkdayRule;
use Illuminate\Validation\Rule;

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
            'workday.id' => ['required', 'integer', new WorkdayRule($this->endedTime)],
            'parallel.id' => [
                'required', 'integer',
                // Rule::unique('cecy.detail_planifications')->where(fn ($query) => $query->where('planification_id', $this->planification))
            ],
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

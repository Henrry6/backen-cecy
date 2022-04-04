<?php

namespace App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\HoursRule;
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
            'workday.id' => ['required', 'integer', new WorkdayRule($this->endedTime)],
            'planification.id' => [
                'required', 'integer',
                new HoursRule($this->day, $this->startedTime, $this->endedTime)
            ],
            'parallel.id' => [
                'required', 'integer',
                // Rule::unique('pgsql-cecy.detail_planifications', 'parallel_id')
                //     ->where(
                //         fn ($query) => $query
                //             ->where('planification_id', $this->planification)
                //     )
            ],
            'endedTime' => ['required', 'after:startedTime', 'date_format:"H:i:s"'],
            'startedTime' => ['required', 'date_format:"H:i:s"'],
            'observation' => ['sometimes', 'required', 'string', 'min:10'],
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
            'observation' => 'observación',
            'startedTime' => 'hora de inicio',
        ];
    }
}

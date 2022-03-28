<?php

namespace App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications;

use App\Rules\HoursRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
                Rule::unique('pgsql-cecy.detail_planifications', 'parallel_id')
                    // ->ignore(request('detailPlanification')->id)
                    ->ignore($this->route('detailPlanification')->id)
                    ->where(fn ($query) => $query->where('planification_id', $this->planification)),
            ],
            'workday.id' => ['required', 'integer', new WorkdayRule($this->endedTime)],
            'planification.id' => [
                'required', 'integer',
                new HoursRule($this->day, $this->startedTime, $this->endedTime)
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
            'parallel.id' => 'paralelo del aula',
            'endedTime' => 'hora de inicio',
            'startedTime' => 'hora de fin',
        ];
    }
}

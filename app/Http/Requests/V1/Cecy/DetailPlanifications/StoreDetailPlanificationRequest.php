<?php

namespace App\Http\Requests\V1\Cecy\DetailPlanifications;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetailPlanificationRequest extends FormRequest
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
            'endedTime' => ['required', 'time'],
            'observations' => ['required', 'integer'],
            'parallel.id' => ['required', 'integer'],
            'planification.id' => ['required', 'integer'],
            'planEndedAt' => ['required', 'date'],
            'registrationsLeft' => ['required', 'integer'],
            'state.id' => ['required', 'integer'],
            'startedTime' => ['required', 'time'],
            'workday.id' => ['required', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'classroom.id' => 'aula',
            'day.id' => 'días de clase',
            'endedTime' => 'hora de final',
            'observations' => 'observaciones',
            'parallel.id' => 'paralelo',
            'planification.id' => 'planificación',
            'planEndedAt' => 'fecha final real de la planificación',
            'registrationsLeft' => 'capacidad restante del paralelo',
            'state.id' => 'estado',
            'startedTime' => 'hora de inicio',
            'workday.id' => 'jornada'
        ];
    }
}

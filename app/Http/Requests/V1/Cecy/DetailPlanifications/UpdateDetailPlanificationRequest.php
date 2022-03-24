<?php

namespace App\Http\Requests\V1\Cecy\DetailPlanifications;

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
            'parallel.id' => ['required', 'integer'],
            'planification.id' => ['required', 'integer'],
            'state.id' => ['required', 'integer'],
            'workday.id' => ['required', 'integer'],
            'endedTime' => ['required', 'time'],
            'observations' => ['required', 'string'],
            'planEndedAt' => ['required', 'date'],
            'registrationsLeft' => ['required', 'integer'],
            'startedTime' => ['required', 'time'],
        ];
    }
    
    public function attributes()
    {
        return [
            'classroom.id' => 'aula',
            'day.id' => 'días de clase',
            'parallel.id' => 'paralelo',
            'planification.id' => 'planificación',
            'state.id' => 'estado',
            'workday.id' => 'jornada',
            'endedTime' => 'hora final',
            'observations' => 'observaciones',
            'planEndedAt' => 'fecha final real de la planificación',
            'registrationsLeft' => 'capacidad restante del paralelo',
            'startedTime' => 'hora de inicio'
        ];
    }
}

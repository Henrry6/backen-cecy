<?php

namespace App\Http\Requests\V1\Cecy\Registrations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'detailPlanification.id' => ['required', 'integer'],
            'finalGrade' => ['required', 'number'],
            'grade1' => ['required', 'number'],
            'grade2' => ['required', 'number'],
            'number' => ['required', 'number'],
            'observations' => ['required'],
            'participant.id' => ['required', 'integer'],
            'registeredAt' => ['required', 'date'],
            'state.id' => ['required', 'integer'],
            'stateCourse.id' => ['required', 'integer'],
            'type.id' => ['required', 'integer'],
            'typeParticipant.id' => ['required', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'detailPlanification.id' => 'Id de planificación',
            'finalGrade' => 'nota final',
            'grade1' => 'nota 1',
            'grade2' => 'nota 2',
            'number' => 'número de identificación de la matrícula',
            'observations' => 'observaciones',
            'participant.id' => 'Id de participante',
            'registeredAt' => 'fecha en que se matriculó',
            'state.id' => 'Id de estado de matrícula',
            'stateCourse.id' => 'Id del estado del curso',
            'type.id' => 'Id de tipo de matrícula',
            'typeParticipant.id' => 'Id del tipo de participante',
        ];
    }
}

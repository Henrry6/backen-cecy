<?php

namespace App\Http\Requests\V1\Cecy\Registrations;

use Illuminate\Foundation\Http\FormRequest;

class GetRegistrationRecordCompetitorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'detailPlanification.id' =>  ['integer', 'required'],
            'participant.id' =>  ['integer', 'required'],
            'state.id' =>  ['integer', 'required'],

        ];
    }

    public function attributes()
    {
        return [
            'detailPlanification.id' => 'Id del detalle de planificacion',
            'participant.id' => 'Id del participante',
            'state.id' => 'matriculado o inscrito',

        ];
    }
}

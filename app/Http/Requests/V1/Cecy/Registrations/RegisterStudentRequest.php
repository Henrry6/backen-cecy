<?php

namespace App\Http\Requests\V1\Cecy\Registrations;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStudentRequest extends FormRequest
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
            'participant.id' => ['required'],
            'type.id' => ['required'],
            'state.id' => ['required'],
            'number' => ['required'],
            'registered_at' => ['required'],
            'levelInstruction.id' => ['required', 'integer'],
            'registration.id' => ['required', 'integer'],
            'companyActivity' => ['required'],
            'companyAddress' => ['required'],
            'companyEmail' => ['required'],
            'companyName' => ['required'],
            'companyPhone' => ['required'],
            'companySponsored' => ['required'],
            'contactName' => ['required'],
            'courseFollows' => ['required'],
            'courseKnows' => ['required'],
            'worked' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'typeParticipant' => 'Tipo de participante',
            'participant.id' => 'Nombre del participante',
            'type.id' => 'tipo de matricula',
            'state.id' => 'Estado de revision en la que se encuentra la solicitud',
            'number' => 'numero de matricula',
            'registered_at' => 'fecha de matricula',
            'levelInstruction.id' => 'Id del nivel de instrucción',
            'registration.id' => 'Id del registro',
            'companyActivity' => 'Actividad de la empresa',
            'companyAddress' => 'Direccion fisica de empresa',
            'companyEmail' => 'Correo de empresa',
            'companyName' => 'Nombre de empresa',
            'companyPhone' => 'Teléfono de empresa',
            'companySponsored' => 'La empresa patrocina',
            'contactName' => 'Nombre de contacto que patrocina',
            'courseFollows' => 'Horas prácticas',
            'courseKnows' => 'Entorno de aprendizaje',
            'worked' => 'Participante trabaja',
        ];
    }
}

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
            'number' => ['required'],
            'additionalInformation.levelInstruction.id' => ['required'],
            'additionalInformation.companyActivity' => ['required'],
            'additionalInformation.companyAddress' => ['required'],
            'additionalInformation.companyEmail' => ['required'],
            'additionalInformation.companyName' => ['required'],
            'additionalInformation.companyPhone' => ['required'],
            'additionalInformation.companySponsored' => ['required'],
            'additionalInformation.contactName' => ['required'],
            'additionalInformation.courseFollows' => ['required'],
            'additionalInformation.courseKnows' => ['required'],
            'additionalInformation.worked' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
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

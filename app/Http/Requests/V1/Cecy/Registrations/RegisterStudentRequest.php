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
            'additionalInformation.levelInstruction.id' => ['required'],
            'additionalInformation.companyActivity' => ['required'],
            'additionalInformation.companyAddress' => ['required'],
            'additionalInformation.companyEmail' => ['required'],
            'additionalInformation.courseFollows' => ['required'],
            'additionalInformation.companyName' => ['required'],
            'additionalInformation.contactName' => ['required'],
            'additionalInformation.companyPhone' => ['required'],
            'additionalInformation.companySponsored' => ['required'],
            'additionalInformation.courseKnows' => ['required'],
            'additionalInformation.worked' => ['required'],
            'number' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'levelInstruction.id' => 'Id del nivel de instrucción',
            'registration.id' => 'Id del registro',
            'companyActivity' => 'actividad de la empresa',
            'companyAddress' => 'dirección fisica de empresa',
            'companyEmail' => 'correo de empresa',
            'courseFollows' => 'horas prácticas',
            'companyName' => 'nombre de empresa',
            'contactName' => 'nombre de contacto que patrocina',
            'companyPhone' => 'teléfono de empresa',
            'companySponsored' => 'la empresa patrocina',
            'courseKnows' => 'entorno de aprendizaje',
            'number' => 'numero de matricula',
            'registeredAt' => 'fecha de matricula',
            'worked' => 'participante que trabaja',
        ];
    }
}

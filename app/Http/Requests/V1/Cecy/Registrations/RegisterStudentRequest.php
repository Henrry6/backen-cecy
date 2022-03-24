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
            'additionalInformation.companyActivity' => ['required'],
            'additionalInformation.companyAddress' => ['required'],
            'additionalInformation.companyEmail' => ['required'],
            'additionalInformation.companyName' => ['required'],
            'additionalInformation.companyPhone' => ['required'],
            'additionalInformation.companySponsored' => ['required'],
            'additionalInformation.contactName' => ['required'],
            'additionalInformation.courseFollows' => ['required'],
            'additionalInformation.courseKnows' => ['required'],
            'additionalInformation.levelInstruction.id' => ['required'],
            'additionalInformation.worked' => ['required'],
            'number' => ['required'],
        ];
    }

    public function attributes()
    {
        //revisar
        return [
            'companyActivity' => 'actividad de la empresa',
            'companyAddress' => 'direccion fisica de empresa',
            'companyEmail' => 'correo de empresa',
            'companyName' => 'nombre de empresa',
            'companyPhone' => 'teléfono de empresa',
            'companySponsored' => 'la empresa patrocina',
            'contactName' => 'nombre de contacto que patrocina',
            'courseFollows' => 'horas prácticas',
            'courseKnows' => 'entorno de aprendizaje',
            'levelInstruction.id' => 'Id del nivel de instrucción',
            'number' => 'numero de matricula',
            'registered_at' => 'fecha de matricula',
            'registration.id' => 'Id del registro',
            'worked' => 'participante que trabaja',
        ];
    }
}

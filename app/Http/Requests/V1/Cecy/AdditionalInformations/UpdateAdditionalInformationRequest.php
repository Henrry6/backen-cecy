<?php

namespace App\Http\Requests\V1\Cecy\AdditionalInformations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdditionalInformationRequest extends FormRequest
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
            'levelInstruction.id' => 'Id del nivel de instrucción',
            'registration.id' => 'Id del registro',
            'companyActivity' => 'actividad de la empresa',
            'companyAddress' => 'dirección fiísica de empresa',
            'companyEmail' => 'correo de empresa',
            'companyName' => 'nombre de empresa',
            'companyPhone' => 'teléfono de empresa',
            'companySponsored' => 'la empresa patrocina',
            'contactName' => 'nombre de contacto que patrocina',
            'courseFollows' => 'horas prácticas',
            'courseKnows' => 'entorno de aprendizaje',
            'worked' => 'participante que trabaja',
        ];
    }
}

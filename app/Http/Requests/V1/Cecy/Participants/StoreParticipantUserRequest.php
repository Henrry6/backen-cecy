<?php

namespace App\Http\Requests\V1\Cecy\Participants;

use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'username' => ['required', 'max:20'],
            'name' => ['required', 'max:100'],
            'lastname' => ['required', 'max:100'],
            'email' => ['required', 'max:100', 'email'],
            'participantType.id' => ['required', 'integer'],
            'address.mainStreet' => ['required'],
            'address.secondaryStreet' => ['required'],
            'address.cantonLocation.id' => ['required',  'integer']
        ];
    }

    public function attributes()
    {
        return [
            'identificationType' => 'tipo de documento',
            'username' => 'nombre de usuario',
            'name' => 'nombres',
            'lastname' => 'apellidos',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'type.id' => 'Id del tipo de participante'
        ];
    }
}

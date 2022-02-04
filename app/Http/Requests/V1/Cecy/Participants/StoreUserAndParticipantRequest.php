<?php

namespace App\Http\Requests\V1\Cecy\Participants;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserAndParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'identificationType' => ['required'],
            'username' => ['required', 'max:20'],
            'name' => ['required', 'max:100'],
            'lastname' => ['required', 'max:100'],
            'email' => ['required', 'max:100', 'email'],
            'password' => ['required', 'min:8', 'max:16'],
            'type.id' => ['required', 'integer']
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

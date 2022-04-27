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
            'type.id' => ['required', 'integer'],
            'username' => ['required', 'max:20'],
            'name' => ['required', 'max:100'],
            'lastname' => ['required', 'max:100'],
            'email' => ['required', 'max:100', 'email'],
            'phone' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'type.id' => 'tipo de participante',
            'username' => 'nombre de usuario',
            'name' => 'nombres',
            'lastname' => 'apellidos',
            'email' => 'correo electrónico',
            'phone' => 'teléfono',
        ];
    }
}

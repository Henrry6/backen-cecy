<?php

namespace App\Http\Requests\V1\Cecy\Participants;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'personType.id' => ['required', 'integer'],
            'state.id' => ['required', 'integer'],
            'user.id' => ['required', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'personType.id' => 'Tipo de participante',
            'state.id' => 'Estado del partipante',
            'user.id' => 'Usuario',
        ];
    }
}

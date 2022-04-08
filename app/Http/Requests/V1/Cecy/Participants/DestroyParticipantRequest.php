<?php
namespace App\Http\Requests\V1\Cecy\Participants;

use Illuminate\Foundation\Http\FormRequest;

class DestroyParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'id' => ['required', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'ID del participante',
        ];
    }

    public function messages()
    {
        return [
            'id' => 'Es obligatorio enviar un Id de tipo número entero',
        ];
    }
}
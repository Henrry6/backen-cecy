<?php

namespace App\Http\Requests\V1\Cecy\Certificates;

use Illuminate\Foundation\Http\FormRequest;

class ShowParticipantsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'course_id' => ['required','integer'],
            'certificateType' => ['required','integer'],
            'state.id' => ['required','integer'],
            'code' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'course_id' => 'id del curso',
            'certificateType' => 'Tipo de certificado',
            'state.id' => 'Estado del certificado',
            'code' => 'codigo del certificado'
        ];
    }
}
<?php

namespace App\Http\Requests\V1\Cecy\ParticipantCourse;

use Illuminate\Foundation\Http\FormRequest;

class DestroysParticipantCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'ids' => ['required', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'ids' => 'ID`s del registro',
        ];
    }

    public function messages()
    {
        return [
            'ids' => 'Es obligatorio enviar un Id de tipo número entero',
        ];
    }
}

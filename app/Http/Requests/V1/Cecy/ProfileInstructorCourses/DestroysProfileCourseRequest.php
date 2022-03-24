<?php

namespace App\Http\Requests\V1\Cecy\ProfileInstructorCourses;

use Illuminate\Foundation\Http\FormRequest;

class DestroysProfileCourseRequest extends FormRequest
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
            'ids' => 'ID`s del perfil del instructor',
        ];
    }

    public function messages()
    {
        return [
            'ids' => 'es obligatorio enviar un Id de tipo número entero',
        ];
    }
}

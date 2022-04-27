<?php

namespace App\Http\Requests\V1\Cecy\Courses;

use Illuminate\Foundation\Http\FormRequest;

class ApproveCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'approvedAt' => ['required', 'date'],
            'code' => ['required', 'string', 'max:100'],
            'expiredAt' => ['required', 'date'],
        ];
    }

    public function attributes()
    {
        return [
            'approvedAt' => 'fecha de aprobación del curso',
            'code' => 'código',
            'expiredAt' => 'fecha de expiración del curso',
        ];
    }
}

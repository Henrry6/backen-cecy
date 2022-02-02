<?php

namespace App\Http\Requests\V1\Cecy\ParticipantCourse;

use Illuminate\Foundation\Http\FormRequest;

class IndexParticipantCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }
}

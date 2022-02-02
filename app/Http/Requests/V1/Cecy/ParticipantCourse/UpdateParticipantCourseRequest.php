<?php

namespace App\Http\Requests\V1\Cecy\ParticipantCourse;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParticipantCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'course.id' => ['required', 'integer'],
            'participantType.id' => ['required', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'course.id' => 'Id del curso',
            'participantType.id' => 'Id del tipo de participante',
        ];
    }
}

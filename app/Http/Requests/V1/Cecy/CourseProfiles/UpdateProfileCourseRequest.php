<?php

namespace App\Http\Requests\V1\Cecy\CourseProfiles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'course.id' => ['required', 'integer'],
            'requiredExperiences' => ['required'],
            'requiredKnowledges' => ['required'],
            'requiredSkills' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'course.id' => 'ID del curso',
            'requiredExperiences' => 'experiencia requerida',
            'requiredKnowledges' => 'conocimiento requerido',
            'requiredSkills' => 'habilidades requeridas'
        ];
    }
}

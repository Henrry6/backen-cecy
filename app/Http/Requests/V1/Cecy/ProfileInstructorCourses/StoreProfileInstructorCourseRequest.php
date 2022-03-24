<?php

namespace App\Http\Requests\V1\Cecy\ProfileInstructorCourses;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileInstructorCourseRequest extends FormRequest
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
      'requiredSkills' => ['required'],
    ];
  }
//REVISAR
  public function attributes()
  {
    return [
      'course.id' => 'Fk de curso',
      'requiredExperiences' => 'experiencias del instructor',
      'requiredKnowledges' => 'conocimientos del instructor',
      'requiredSkills' => 'habilidades del instructor',
    ];
  }
}

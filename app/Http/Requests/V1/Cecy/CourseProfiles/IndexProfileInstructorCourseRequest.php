<?php

namespace App\Http\Requests\V1\Cecy\CourseProfiles;

use Illuminate\Foundation\Http\FormRequest;

class IndexProfileInstructorCourseRequest extends FormRequest
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
}

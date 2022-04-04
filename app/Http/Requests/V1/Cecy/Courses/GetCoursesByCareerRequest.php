<?php

namespace App\Http\Requests\V1\Cecy\Courses;

use Illuminate\Foundation\Http\FormRequest;

class GetCoursesByCareerRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      // 'schoolPeriod.id' => ['required', 'integer'],
    ];
  }

  public function attributes()
  {
    return [
      // 'schoolPeriod.id' => 'Id de periodo lectivo',
    ];
  }
}

<?php

namespace App\Http\Requests\V1\Cecy\Courses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStateCourseRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      
      'id' => ['required'],
      
    ];
  }

  public function attributes()
  {
    return [

      'id' => 'Id del estado del curso',
    ];
  }
}

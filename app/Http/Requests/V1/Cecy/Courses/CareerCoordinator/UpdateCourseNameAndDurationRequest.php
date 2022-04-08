<?php

namespace App\Http\Requests\V1\Cecy\Courses\CareerCoordinator;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseNameAndDurationRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'duration' => ['required', 'integer'],
      'name' => ['required','string'],
    ];
  }

  public function attributes()
  {
    return [
      'duration' => 'duración',
      'name' => 'nombre',
    ];
  }
}

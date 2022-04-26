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
      'responsible.id' => ['required', 'integer'],
      'duration' => ['required', 'integer'],
      'name' => ['required', 'string'],
    ];
  }

  public function attributes()
  {
    return [
      'responsible.id' => 'estado',
      'duration' => 'duración',
      'name' => 'nombre',
    ];
  }
}

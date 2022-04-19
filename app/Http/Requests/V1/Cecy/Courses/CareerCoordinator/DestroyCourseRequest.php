<?php

namespace App\Http\Requests\V1\Cecy\Courses\CareerCoordinator;

use Illuminate\Foundation\Http\FormRequest;

class DestroyCourseRequest extends FormRequest
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

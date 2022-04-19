<?php

namespace App\Http\Requests\V1\Cecy\Planifications;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanificationByCourseRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'responsibleCourse.id' => ['required', 'integer'],
      'endedAt' => ['required', 'date'],
      'startedAt' => ['required', 'date'],
    ];
  }

  public function attributes()
  {
    return [
      'responsibleCourse.id' => 'responsable de planificación',
      'endedAt' => 'fecha de finalización',
      'startedAt' => 'fecha de inicio',
    ];
  }
}
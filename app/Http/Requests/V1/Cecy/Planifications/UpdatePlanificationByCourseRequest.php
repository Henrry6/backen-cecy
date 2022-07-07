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
      'endedAt' => ['required', 'date', 'after:startedAt'],
      'startedAt' => ['required', 'date'],
    ];
  }

  public function attributes()
  {
    return [
      'responsibleCecy.id' => 'responsable de planificación',
      'endedAt' => 'fecha de finalización',
      'startedAt' => 'fecha de inicio',
    ];
  }
}
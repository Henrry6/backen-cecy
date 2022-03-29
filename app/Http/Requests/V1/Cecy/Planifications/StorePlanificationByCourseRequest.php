<?php

namespace App\Http\Requests\V1\Cecy\Planifications;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanificationByCourseRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'responsible.id' => ['required', 'integer'],
      'endedAt' => ['required', 'date'],
      'startedAt' => ['required', 'date'],

    ];
  }

  public function attributes()
  {
    return [
      'responsible.id' => 'responsable de planificación',
      'endedAt' => 'fecha de finalización',
      'startedAt' => 'fecha de inicio',
    ];
  }
}

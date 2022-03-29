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
      'duration' => ['required', 'integer'],
      'endedAt' => ['required', 'date'],
      'name' => ['required'],
      'startedAt' => ['required', 'date'],

    ];
  }

  public function attributes()
  {
    return [
      'responsible.id' => 'responsable de planificación',
      'duration' => 'duración',
      'endedAt' => 'fecha de finalización',
      'name' => 'nombre',
      'startedAt' => 'fecha de inicio',
    ];
  }
}

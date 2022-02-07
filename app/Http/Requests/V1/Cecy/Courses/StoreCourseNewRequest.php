<?php

namespace App\Http\Requests\V1\Cecy\Courses;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseNewRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'career.id' => ['required', 'integer'],
      'state.id' => ['required', 'integer'],
      'code' => ['required', 'max:100'],
      'duration' => ['required', 'integer'],
      'name' => ['required', 'string', 'max:200'],
      'observation' => ['required', 'string', 'max:1000'],
    ];
  }

  public function attributes()
  {
    return [
      'career.id' => 'Id de la carrera',
      'state.id' => 'Id del estado del curso',
      'code' => 'Código',
      'duration' => 'Duración',
      'name' => 'Nombre',
      'observation' => 'Observación',
    ];
  }
}

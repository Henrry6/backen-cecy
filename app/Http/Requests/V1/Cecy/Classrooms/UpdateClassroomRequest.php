<?php

namespace App\Http\Requests\V1\Cecy\Classrooms;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassroomRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'type.id' => ['required', 'integer'],
      'description' => ['required', 'string'],
      'capacity' => ['required', 'integer'],
      'code' => ['required', 'string'],
      'name' => ['required', 'string'],
    ];
  }

  public function attributes()
  {
    return [
      'type.id' => 'Tipo de aula',
      'description' => 'Descripción del aula',
      'capacity' => 'Capacidad del aula a recibir',
      'code' => 'Código del aula',
      'name' => 'Nombre del aula',
    ];
  }
}

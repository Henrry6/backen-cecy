<?php

namespace App\Http\Requests\V1\Cecy\Requirements;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequirementRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'state.id' => ['required', 'integer'],
      'name' => ['required'],
      'required' => ['required'],
    ];
  }

  public function attributes()
  {
    return [
      'state.id' => 'estado',
      'name' => 'nombre del campo',
      'required' => 'requerido',
    ];
  }
}

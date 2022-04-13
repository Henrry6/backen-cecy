<?php

namespace App\Http\Requests\V1\Cecy\Planifications;

use Illuminate\Foundation\Http\FormRequest;

class AssignResponsibleCecyRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'responsibleCecy.id' => ['required', 'integer']
    ];
  }

  public function attributes()
  {
    return [
      'responsibleCecy.id' => 'responsable del cecy'
    ];
  }
}

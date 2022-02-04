<?php

namespace App\Http\Requests\V1\Cecy\Authorities;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorityRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'intitution.id' => ['required', 'integer'],
      'position.id' => ['required', 'integer'],
      'user.id' => ['required', 'integer'],
      'state.id' => ['required', 'integer'],
      'positionStartedAt' => ['required', 'integer'],
      'positionEndedAt' => ['required', 'integer'],
      'electronicSignature' => ['required', 'integer'],
    ];
  }

  public function attributes()
  {
    return [
      'intitution.id' => 'Id de la institucion',
      'position.id' => 'Id de la posicion',
      'user.id' => 'Id del usuario',
      'state.id' => 'Id del estato',
      'positionStartedAt' => 'Fecha inicio',
      'positionEndedAt' => 'Fecha final',
      'electronicSignature' => ' Firma electronica ',
    ];
  }
}

<?php

namespace App\Http\Requests\V1\Cecy\Institutions;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstitutionsRequest extends FormRequest
{
    public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'code'=> ['required', 'string'],
      'name'=> ['required', 'string'],
      'logo'=> ['required', 'integer'],
      'slogan'=> ['required', 'string'],
    ];
  }

  public function attributes()
  {
    return [
      'code'=> 'código de la institución',
      'name'=> 'Nombre de la institución',
      'logo'=> 'Logo de la institución',
      'slogan'=> 'Slogan de la institución',
    ];
  }
}

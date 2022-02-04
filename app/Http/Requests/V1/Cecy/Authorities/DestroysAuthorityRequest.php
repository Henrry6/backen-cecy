<?php

namespace App\Http\Requests\V1\Cecy\Authorities;

use Illuminate\Foundation\Http\FormRequest;

class DestroysAuthorityRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'ids' => ['required'],
    ];
  }

  public function attributes()
  {
    return [
      'ids' => 'ID`s de las autoridades',
    ];
  }
}

<?php

namespace App\Http\Requests\V1\Cecy\Authorities;

use Illuminate\Foundation\Http\FormRequest;

class CatalogueAuthorityRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [];
  }

  public function attributes()
  {
    return [];
  }
}

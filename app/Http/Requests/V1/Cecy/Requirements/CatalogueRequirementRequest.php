<?php

namespace App\Http\Requests\V1\Cecy\Requirements;

use Illuminate\Foundation\Http\FormRequest;

class CatalogueRequirementRequest extends FormRequest
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

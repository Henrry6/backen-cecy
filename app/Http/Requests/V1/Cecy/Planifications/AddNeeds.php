<?php

namespace App\Http\Requests\V1\Cecy\Planifications;

use Illuminate\Foundation\Http\FormRequest;

class AddNeeds extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'needs' => ['required', 'array'],
      'needs.*' => ['string', 'min:10'],
    ];
  }

  public function attributes()
  {
    return [
      'needs' => 'necesidades',
    ];
  }
}

<?php

namespace App\Http\Requests\V1\Cecy\Planifications;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatePlanificationRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [

      'id' => ['required'],

    ];
  }

  public function attributes()
  {
    return [
    
      'id' => 'Id del estado',
      
    ];
  }
}

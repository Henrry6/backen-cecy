<?php

namespace App\Http\Requests\V1\Cecy\AdditionalInformations;

use Illuminate\Foundation\Http\FormRequest;

class DestroysAnnualOperativePlanRequest  extends FormRequest
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
            'id' => 'Id de Poa',
        ];
    }
}

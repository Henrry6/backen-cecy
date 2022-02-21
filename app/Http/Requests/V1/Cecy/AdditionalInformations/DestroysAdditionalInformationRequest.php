<?php

namespace App\Http\Requests\V1\Cecy\AdditionalInformations;

use Illuminate\Foundation\Http\FormRequest;

class DestroysAdditionalInformationRequest  extends FormRequest
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
            'id' => 'Id del additional information',
        ];
    }
}

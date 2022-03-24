<?php

namespace App\Http\Requests\V1\Cecy\Certificates;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'state.id' => ['required','integer'],
            'certificateType' => ['required','integer'],
            'code' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'state.id' => 'estado del certificado',
            'certificateType' => 'tipo de certificado',
            'code' => 'codigo del certificado'
        ];
    }
}

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
            'certificateType' => ['required','integer'],
            'state.id' => ['required','integer'],
            'code' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'certificateType' => 'Tipo de certificado',
            'state.id' => 'Estado del certificado',
            'code' => 'codigo del certificado'
        ];
    }
}

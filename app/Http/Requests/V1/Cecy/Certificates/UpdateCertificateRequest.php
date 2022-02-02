<?php

namespace App\Http\Requests\V1\Cecy\Certificates;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCertificateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'certificate_type' => ['required','integer'],
            'state.id' => ['required','integer'],
            'code' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'certificate_type' => 'Tipo de certificado',
            'state.id' => 'Estado del certificado',
            'code' => 'codigo del certificado'
        ];
    }
}

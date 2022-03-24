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
            'state.id' => ['required','integer'],
            'certificate_type' => ['required','integer'],
            'code' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'state.id' => 'estado del certificado',
            'certificate_type' => 'tipo de certificado',
            'code' => 'codigo del certificado'
        ];
    }
}

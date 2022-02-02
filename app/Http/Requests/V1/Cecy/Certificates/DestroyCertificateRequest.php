<?php

namespace App\Http\Requests\V1\Cecy\Certificates;

use Illuminate\Foundation\Http\FormRequest;

class DestroyCertificateRequest  extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'ids' => ['required'],
            'certificateType' => ['required','integer'],
            'state.id' => ['required','integer'],
            'code' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'ids' => 'ID`s de los certificados',
            'certificateType' => 'Tipo de certificado',
            'state.id' => 'Estado del certificado',
            'code' => 'codigo del certificado'
        ];
    }
}

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
            'state.id' => ['required','integer'],
            'certificateType' => ['required','integer'],
            'code' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'ids' => 'ID`s de los certificados',
            'state.id' => 'estado del certificado',
            'certificateType' => 'tipo de certificado',
            'code' => 'codigo del certificado'
        ];
    }
}

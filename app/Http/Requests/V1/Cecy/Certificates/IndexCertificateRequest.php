<?php

namespace App\Http\Requests\V1\Cecy\Certificates;

use Illuminate\Foundation\Http\FormRequest;

class IndexCertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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

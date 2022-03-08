<?php

namespace App\Http\Requests\V1\Cecy\Registrations;

use Illuminate\Foundation\Http\FormRequest;

class NullifyRegistrationRequest extends FormRequest
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
            'ids' => ['required', 'array'],
            'observations' => ['required',],
            
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'Id´s de planificación',
            'observations' => 'observaciones del registro',
            
        ];
    }
}

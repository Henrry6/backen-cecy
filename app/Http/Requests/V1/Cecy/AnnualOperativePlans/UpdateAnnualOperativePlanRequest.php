<?php

namespace App\Http\Requests\V1\Cecy\AdditionalInformations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnualOperativePlanRequest extends FormRequest
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

            'tradeNumber'=> ['required'],
            'year'=> ['required'],
            'officialDateAt'=> ['required'],
            'activities'=> ['required']
        ];
    }

    public function attributes()
    {
        return [

            'tradeNumber'=> 'Numero de oficio',
            'year'=> 'año del oficio',
            'officialDateAt'=> 'fecha del oficio',
            'activities'=> 'actividades'
        ];
    }
}

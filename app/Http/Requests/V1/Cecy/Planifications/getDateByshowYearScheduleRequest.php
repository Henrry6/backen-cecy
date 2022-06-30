<?php

namespace App\Http\Requests\V1\Cecy\Planifications;

use Illuminate\Foundation\Http\FormRequest;

class GetDateByshowYearScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'startedAt' => ['required', 'integer']

        ];
    }

    public function attributes()
    {
        return [
            'startedAt' => 'fecha de la planificacion'

        ];
    }
}

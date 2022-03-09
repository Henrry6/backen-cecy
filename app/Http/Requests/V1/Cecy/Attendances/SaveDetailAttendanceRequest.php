<?php

namespace App\Http\Requests\V1\Cecy\Attendances;

use Illuminate\Foundation\Http\FormRequest;

class SaveDetailAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'type.id' => ['required', 'integer'],
            // 'registration.id'=> ['required','integer']
        ];
    }

    public function attributes()
    {
        return [
            'type.id' => 'tipo de  asistencia',
            // 'registration.id'=> 'id del registro'
        ];
    }
}

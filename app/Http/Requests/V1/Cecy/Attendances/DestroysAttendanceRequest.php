<?php

namespace App\Http\Requests\V1\Cecy\Attendances;

use Illuminate\Foundation\Http\FormRequest;

class DestroysAttendanceRequest  extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'ids' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'ids' => 'ID`s de todas las asistencia de ese dia',
        ];
    }
}

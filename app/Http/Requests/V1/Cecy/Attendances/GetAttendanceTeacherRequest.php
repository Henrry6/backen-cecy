<?php

namespace App\Http\Requests\V1\Cecy\Attendances;

use Illuminate\Foundation\Http\FormRequest;

class GetAttendanceTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'duration' => ['required'],
            'registered_at' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'duration' => 'duración',
            'registered_at' => 'fecha'
        ];
    }
}

<?php

namespace App\Http\Requests\V1\Cecy\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetailAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        //revisar
        return [
            'attendance_id' => ['required', 'integer'],
            'registration_id' => ['required'],
            'type_id' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'attendance_id' => 'Id de la asistencia',
            'registration_id' => 'Id del registro',
            'type_id' => 'tipo de asistencia'
        ];
    }
}


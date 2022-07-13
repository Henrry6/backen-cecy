<?php

namespace App\Http\Requests\V1\Cecy\Attendances;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'detailPlanificationId' => ['required', 'integer'],
            'duration' => ['required'],
            'registeredAt' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'detailPlanificationId' => 'detalle de planificacion id',
            'duration' => 'duración de la clase',
            'registeredAt' => 'fecha de la clase'
        ];
    }
}

<?php

namespace App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications;

use Illuminate\Foundation\Http\FormRequest;

class DestroysDetailPlanificationRequest extends FormRequest
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
            'ids' => 'ids de los detalles de planificación',
        ];
    }
}

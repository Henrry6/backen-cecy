<?php

namespace App\Http\Requests\V1\Cecy\DetailPlanifications;

use Illuminate\Foundation\Http\FormRequest;

class AssignInstructorsRequest  extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            // 'ids' => ['required', 'array'],
            // 'ids.*' => ['integer'],
        ];
    }

    public function attributes()
    {
        return [
            // 'ids' => 'instructores',
        ];
    }
}

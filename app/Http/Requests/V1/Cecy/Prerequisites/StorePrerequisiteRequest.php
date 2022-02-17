<?php

namespace App\Http\Requests\V1\Cecy\Prerequisites;

use Illuminate\Foundation\Http\FormRequest;

class StorePrerequisiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'prerequisite.id' => ['required', 'max:240'],
        ];
    }

    public function attributes()
    {
        return [
            'prerequisite.id' => 'Id del curso que prerequisito',
        ];
    }
}
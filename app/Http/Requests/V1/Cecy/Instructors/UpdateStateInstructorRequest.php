<?php

namespace App\Http\Requests\V1\Cecy\Instructors;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStateInstructorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'state.id' => ['required', 'integer'],
            'user.id' => ['required', 'integer']
        ];
    }

    public function attributes()
    {
        return [
            'state.id' => 'Estado del instructor',
            'user.id' => 'Id del usuario'
        ];
    }
}

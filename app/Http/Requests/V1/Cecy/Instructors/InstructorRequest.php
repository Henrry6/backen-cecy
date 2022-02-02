<?php
namespace App\Http\Requests\V1\Cecy\Participants;

use Illuminate\Foundation\Http\FormRequest;

class InstructorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'instructor.id' => ['required', 'integer'],
            'period.id' => ['required', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'instructor.id' => 'Id del instructor',
            'period.id' => 'Id del periodo',

        ];
    }

    public function messages()
    {
        return [

            'instructor.id' => 'Id del instructor requerido',
            'period.id' => 'Id del requerido',
        ];
    }
}
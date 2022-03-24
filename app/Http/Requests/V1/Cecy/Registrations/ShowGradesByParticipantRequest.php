<?php

namespace App\Http\Requests\V1\Cecy\Registrations;

use Illuminate\Foundation\Http\FormRequest;

class ShowGradesByParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'finalGrade' => ['required'],
            'grade1' => ['required'],
            'grade2' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'final_grade' => 'Nota final',
            'grade1' => 'Nota primer parcial',
            'grade2' => 'Nota segundo parcial'

        ];
    }
}

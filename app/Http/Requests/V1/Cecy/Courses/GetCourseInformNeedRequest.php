<?php

namespace App\Http\Requests\V1\Cecy\Courses;

use Illuminate\Foundation\Http\FormRequest;

class GetCourseInformNeedRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'courseType.id' =>  ['integer', 'required'],
            'modality.id' =>  ['integer', 'required'],
            'name' =>  ['string', 'required'],

        ];
    }

    public function attributes()
    {
        return [
            'name' =>  'nombre del curso',
            'courseType.id' => 'Id  del tipo de curso',
            'modality.id' => 'Id  de la modalidad',
        ];
    }
}

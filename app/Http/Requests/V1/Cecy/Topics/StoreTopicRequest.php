<?php

namespace App\Http\Requests\V1\Cecy\Topics;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'course.id' => ['integer'],
            'parent.id' => ['integer'],
            'children' => ['json'],
            'level' => ['required', 'integer'],
            'description' => ['required', 'max:240'],
        ];
    }

    public function attributes()
    {
        return [
            'course.id' => 'Id del curso',
            'parent.id' => 'Id del tema principa',
            'children' => 'subtemas',
            'level' => 'tipo de nivel, tema o subtema',
            'description' => 'descripción del tema o subtemas',
        ];
    }
}

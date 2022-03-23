<?php

namespace App\Http\Requests\V1\Cecy\Topics;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicRequest extends FormRequest
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
            'level' => ['integer'],
            'description' => ['required', 'max:240'],
        ];
    }

    public function attributes()
    {
        return [
            'course.id' => 'Id del tema principa',
            'parent.id' => 'Id del tema principa',
            'children' => 'json',
            'level' => 'tipo de nivel, tema o subtema',
            'description' => 'descripción del tema o subtemas',
        ];
    }
}

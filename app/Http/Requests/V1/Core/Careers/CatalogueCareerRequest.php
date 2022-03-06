<?php

namespace App\Http\Requests\V1\Core\Careers;

use Illuminate\Foundation\Http\FormRequest;

class CatalogueCareerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        return $rules;
    }

    public function attributes()
    {
        $attributes = [];
        return $attributes;
    }
}

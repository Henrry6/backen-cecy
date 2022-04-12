<?php

namespace App\Http\Requests\V1\Core\Careers;

use Illuminate\Foundation\Http\FormRequest;

class GetCareersByCoordinatorCareerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }
}

<?php

namespace App\Http\Requests\V1\Cecy\DetailSchoolPeriods;

use Illuminate\Foundation\Http\FormRequest;

class CatalogueDetailSchoolPeriodRequest extends FormRequest
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
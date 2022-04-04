<?php

namespace App\Http\Requests\V1\Cecy\DetailAttendance;

use Illuminate\Foundation\Http\FormRequest;

class CatalogueDetailAttendanceRequest extends FormRequest
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

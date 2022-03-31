<?php

namespace App\Http\Requests\V1\Cecy\Topics;

use Illuminate\Foundation\Http\FormRequest;

class CatalogueTopicRequest  extends FormRequest
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

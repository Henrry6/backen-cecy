<?php

namespace App\Http\Requests\V1\Cecy\Courses;

use Illuminate\Foundation\Http\FormRequest;

class UploadCertificateOfApprovalRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  
}

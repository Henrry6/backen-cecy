<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\DetailPlanifications\AssignInstructorsRequest;
use App\Http\Resources\V1\Cecy\CourseProfiles\CourseProfileResource;
use App\Models\Cecy\CourseProfile;

class CourseProfileController extends Controller
{
    public function __construct()
    {
      //$this->middleware('permission:store')->only(['store']);
      //$this->middleware('permission:update')->only(['update']);
      //$this->middleware('permission:delete')->only(['destroy', 'destroys']);
    }

     
}

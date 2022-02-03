<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByCategoryRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByNameRequest;
use App\Http\Requests\V1\Cecy\Courses\IndexCourseRequest;
use App\Http\Requests\V1\Cecy\Participants\StoreUserAndParticipantRequest;
use App\Http\Requests\V1\Cecy\Planifications\IndexPlanificationRequest;
use App\Http\Requests\V1\Core\Files\DestroysFileRequest;
use App\Http\Requests\V1\Core\Files\UpdateFileRequest;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Courses\CoursePublicPrivateCollection;
use App\Http\Resources\V1\Cecy\Courses\TopicsByCourseCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteCollection;
use App\Http\Resources\V1\Cecy\Users\UserResource;
use App\Http\Resources\V1\Core\Users\UserCollection;
use App\Models\Authentication\User;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Planification;
use App\Models\Core\File;
use App\Models\Core\Image;
use Illuminate\Support\Facades\DB;

class GuachagmiraController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:view-courses')->only(['view']);
        // $this->middleware('permission:view-topics')->only(['view']);
        // $this->middleware('permission:view-prerequisites')->only(['view']);
        // $this->middleware('permission:view-detailPlanifications')->only(['view']);
        // $this->middleware('permission:view-Instructors')->only(['view']);
        // $this->middleware('permission:view-Planifications')->only(['view']);
    }
}

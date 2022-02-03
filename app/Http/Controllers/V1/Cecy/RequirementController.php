<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Courses\getCoursesByResponsibleRequest;
use App\Http\Requests\V1\Cecy\DetailPlanifications\DetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\Participants\InstructorRequest;
use App\Http\Requests\V1\Cecy\Registrations\IndexRegistrationRequest;
use App\Http\Requests\V1\Cecy\Registrations\UpdateRegistrationRequest;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Courses\CourseParallelWorkdayResource;
use App\Http\Resources\V1\Cecy\Participants\ParticipantInformationResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationCollection;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationParticipantCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Http\Resources\V1\Core\Users\UserResource;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Planification;
use App\Models\Cecy\Registration;
use App\Models\Cecy\Requirement;
use App\Models\Core\File;
use App\Models\Core\Image;
use Illuminate\Http\Request;


class RequirementController extends Controller
{

    /*******************************************************************************************************************
     * FILES
     ******************************************************************************************************************/
    /*ver documentos  requeridos para un registro                  */
    // RequirementController
    public function showFile(Requirement $Requirement, File $file)
    {
        return $Requirement->showFile($file);
    }


    /*******************************************************************************************************************
     * IMAGES
     ******************************************************************************************************************/
    /*ver documentos  requeridos para un registro */
    // RequirementController
    public function showImage(Requirement $Requirement, Image $image)
    {
        return $Requirement->showImage($image);
    }

}

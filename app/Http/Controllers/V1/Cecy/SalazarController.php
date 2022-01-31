<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Cecy\ProfileInstructorCourses\ProfileInstructorCourseCollection;
use App\Http\Resources\V1\Cecy\ProfileInstructorCourses\ProfileInstructorCourseResource;
use Illuminate\Http\Request;
use App\Models\Cecy\ProfileInstructorCourse;
use App\Models\Cecy\Course;    
use App\Http\Resources\V1\Cecy\Planifications\InformCourseNeedsResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationInformNeedResource;
use App\Http\Resources\V1\Cecy\Registration\RegistrationRecordCompetitorResource;


class SalazarController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show')->only(['show']);
    }

      public function showCurricularDesign(Course $course)
      {
        // trae la informacion de diseño curricular 

    $planification = $course->planifications()->get()
        ->detailPlanifications()
        ->planifications()
        ->course()
        ->paginate($request->input('per_page'));

    return (new InformCourseNeedsResource($planification))
        ->additional([
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ]);
    }

      
      public function showAttendenceEvaluationRecord(Course $course)
      {
         // trae la informacion de registro asistencia-evaluacion
         $course = Course::where('course_id', $request->course()->id)->get();

    $detailPlanifications = $course
        ->detailPlanifications()
        ->planifications()
        ->course()
        ->registration()
        ->attendence()
        ->paginate($request->input('per_page'));

    return (new RegistrationRecordCompetitorResource($detailPlanifications))
        ->additional([
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ]);
    }
      
  
      public function showFinalCourseReport(Course $course)
      {
       // trae la informacion del informe final del curso 

       $course = Course::where('course_id', $request->course()->id)->get();

       $detailPlanifications = $course
        ->detailPlanifications()
        ->planifications()
        ->instructors()
        ->course()
        ->registration()
        ->paginate($request->input('per_page'));

       
        return (new InformCourseNeedsResource($course))
        ->additional([
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ]);
    }
         
      }

  
    
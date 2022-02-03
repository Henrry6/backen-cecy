<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Attendance\GetAttendancesByParticipantRequest;
use App\Http\Requests\V1\Cecy\Attendance\SaveDetailAttendanceRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Prerequisite;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteCollection;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteResource;
use App\Http\Requests\V1\Cecy\Prerequisites\DestroyPrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\StorePrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\UpdatePrerequisiteRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetDetailPlanificationsByResponsibleCourseRequest;
use App\Http\Resources\V1\Cecy\Attendances\GetAttendanceByParticipantCollection;
use App\Http\Resources\V1\Cecy\Attendances\SaveDetailAttendanceResource;
use App\Http\Resources\V1\Cecy\PhotographicRecords\PhotographicRecordResource;
use App\Models\Cecy\Attendance;
use App\Models\Cecy\Registration;

class AttendanceController extends Controller
{
 //Ver todas las asistencias del estudiante
    // AttendanceController
    public function getAttendancesByParticipant(GetAttendancesByParticipantRequest $request, Registration $registration)
    {
        $detailPlanification = $registration->detailPlanification()->first();
        $attendances = $detailPlanification
            ->attendances()
            ->paginate($request->input('per_page'));

        return (new GetAttendanceByParticipantCollection($attendances))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    // Guardar asistencia
    // AttendanceController
    public function saveDetailAttendances(SaveDetailAttendanceRequest $request, Attendance $attendance)
    {
        $attendance->state_id = $request->input('state.id');
        $attendance->save();

        return (new SaveDetailAttendanceResource($attendance))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
      // AttendanceController
      public function showPhotographicRecord(GetDetailPlanificationsByResponsibleCourseRequest $request, Course $course)
      {
          //trae el registro fotografico de un curso en especifico por el docente que se loguea
  
          /*         $planification = $course->planifications()->get();
                  $detailPlanification = $planification->detailPlanifications()->get();
                  $detailPlanificationInstructor = $detailPlanification->instructors()->get();
                  $instructor = $detailPlanificationInstructor->users()->get(); */
  
          $planification = $course->planifications()->get();
          $detailPlanification = $planification->detailPlanifications()->get();
          $photograpicRecord = $detailPlanification->photograpicRecord()->get();
  
  
          /* $detailPlanificationInstructor = $detailPlanification->certificateable()->get; */
  
          /*       $Planifications = $responsibleCourse
                    ->detailPlanifications()
                    ->photographicRecords()
                    ->paginate($request->input('per_page')); */
          /*    $responsibleCourse = Instructor::where('user_id', $request->user()->id)->get();
  
             $Planifications = $responsibleCourse
                 ->detailPlanifications()
                 ->photographicRecords()
                 ->paginate($request->input('per_page')); */
  
          return (new PhotographicRecordResource($photograpicRecord))
              ->additional([
                  'msg' => [
                      'summary' => 'success',
                      'detail' => '',
                      'code' => '200'
                  ]
              ])
              ->response()->setStatusCode(200);
      }
}



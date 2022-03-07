<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Attendances\GetAttendancesByParticipantRequest;
use App\Http\Requests\V1\Cecy\Attendance\SaveDetailAttendanceRequest;
use App\Http\Requests\V1\Cecy\Attendance\ShowAttendanceTeacherRequest;
use App\Http\Requests\V1\Cecy\Attendance\StoreAttendanceRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByNameRequest;
use App\Http\Requests\V1\Core\Images\UploadImageRequest;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceCollection;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceResource;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Course;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetDetailPlanificationsByResponsibleCourseRequest;
use App\Http\Resources\V1\Cecy\Attendances\GetAttendanceByParticipantCollection;
use App\Http\Resources\V1\Cecy\Attendances\SaveDetailAttendanceResource;
use App\Http\Resources\V1\Cecy\PhotographicRecords\PhotographicRecordResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationRecordCompetitorResource;
use App\Models\Cecy\Attendance;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;


class AttendanceController extends Controller
{
    //Ver todas las asistencias del estudiante
    // AttendanceController
    public function getAttendancesByParticipant(GetAttendancesByParticipantRequest $request, DetailPlanification $detailPlanification)
    {
        //dd($registration->detailPlanification->attendances);
        $attendances = $detailPlanification->attendances()
            ->paginate($request->input('per_page'));

        return (new GetAttendanceByParticipantCollection($attendances))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta zexitosa 1',
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


        $photograpicRecord = $course->planifications()->first();


        $data = new PhotographicRecordResource($photograpicRecord);
        $pdf = PDF::loadView('reports/photographic-record', ['photograpicRecords' => $data]);

        return $pdf->stream('Registro fotográfico.pdf');
    }

    public function showAttendenceEvaluationRecord(GetCoursesByNameRequest $request, Course $course)
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
    //ver todas las asistencias de un detalle planification
    // AttendanceController
    public function getAttendancesByDetailPlanification(DetailPlanification $detailPlanification)
    {
        $attendances = $detailPlanification->attendances()->get();

        return (new AttendanceCollection($attendances))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
    //crear una asistencia a partir de las fechas y horarios de detalle planificacion.
    // AttendanceController
    public function storeAttendanceTeacher(StoreAttendanceRequest $request)
    {
        $attendance = new Attendance();

        $attendance->detailPlanification()
            ->associate(DetailPlanification::find($request->input('detail_planification.id')));

        $attendance->duration = $request->input('duration');

        $attendance->registered_at = $request->input('registeredAt');

        $attendance->save();

        return (new AttendanceCollection($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    //ver asistencia una por una
    // AttendanceController
    public function showAttendanceTeacher(ShowAttendanceTeacherRequest $request)
    {
        $attendance = Attendance::where([['registered_at', $request->input('registered_at')]])->get();

        return (new AttendanceResource($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'Asistencias encontradas',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    //eliminar una asistencia
    // AttendanceController
    public function destroysAttendanceTeacher(DestroysAttendanceRequest $request)
    {
        $attendance = Attendance::whereIn('id', $request->input('ids'))->get();
        Attendance::destroy($request->input('ids'));

        return (new AttendanceResource($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'Asistencia eliminada',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    public function index()
    {
        return (new AttendanceCollection(Attendance::paginate()))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'Institution' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    public function show(Attendance $attendance)
    {

        return (new AttendanceResource($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'Institution' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    /*******************************************************************************************************************
     * IMAGES
     ******************************************************************************************************************/
    //subir evidencia fotografica
    // AttendanceController
    public function uploadImage(UploadImageRequest $request, PhotograficRecord $photograficRecord)
    {
        $storagePath = storage_path('app/private/images/');
        $image = InterventionImage::make($image);
        $path = $storagePath . time() . '.jpg';
        $image->save($path, 75);

        return $photograficRecord->uploadImage($request);
    }
}

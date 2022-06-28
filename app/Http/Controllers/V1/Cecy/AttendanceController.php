<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Http\Requests\V1\Core\Images\UploadImageRequest;
use App\Http\Requests\V1\Cecy\Attendances\DestroysAttendanceRequest;
use App\Http\Requests\V1\Cecy\Attendances\GetAttendancesByParticipantRequest;
use App\Http\Requests\V1\Cecy\Attendances\SaveDetailAttendanceRequest;
use App\Http\Requests\V1\Cecy\Attendances\ShowAttendanceTeacherRequest;
use App\Http\Requests\V1\Cecy\Attendances\StoreAttendanceRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByNameRequest;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceCollection;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationRecordCompetitorResource;
use App\Http\Resources\V1\Cecy\Attendances\SaveDetailAttendanceResource;
use App\Models\Authentication\User;
use App\Models\Cecy\Attendance;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Institution;
use App\Models\Cecy\Instructor;

class AttendanceController extends Controller
{
    //Metodo Molina
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
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    // AttendanceController
    public function showPhotographicRecord(Course $course, DetailPlanification $detailPlanification)
    {
        //trae el registro fotografico de un curso en especifico
        $planification = $course->planifications()->first();
        $detailPlanification = $planification->detailPlanifications()->with(['day', 'workday'])->first();
        $photographicRecords = $detailPlanification->photographicRecords()->first();
        $pdf = PDF::loadView('reports/photographic-record', [
            'course' => $course,
            'planification' => $planification,
            'detailPlanification' => $detailPlanification,
            'photographicRecords' => $photographicRecords
        ]);
        $pdf->setOptions([
            'orientation' => 'landscape',
        ]);

        return $pdf->stream('Registro fotográfico.pdf');
    }


    //ver todas las asistencias de un detalle planification
    // AttendanceController
    public function getByDetailPlanification(DetailPlanification $detailPlanification)
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
    public function destroys(DestroysAttendanceRequest $request)
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
    public function destroyAttendance( $attendance)
    {
        $attendance = Attendance::find($attendance);
        $attendance->delete();

        return (new AttendanceResource($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'asistencia eliminada',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
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

    //trae informacion del informe de asistencia evaluacion
    public function attendanceEvaluation(Course $course)
    {
        $planification = $course->planifications()->first();
        $detailPlanification = $planification->detailPlanifications()->first();
        $registrations = $detailPlanification->registrations()->get();
        $responsiblececy = $planification->responsibleCecy()->first();
        $institution = Institution::firstWhere('id', $responsiblececy->institution_id);
        $instructor = Instructor::where('id', $planification->responsible_course_id)->first();
        $user = $instructor->user();
        $user = User::firstWhere('id', $instructor->user_id);
        $grade1 = $registrations[0]['grade1'];
        $grade2 = $registrations[0]['grade2'];
        $final_grade = $registrations[0]['final_grade'];


        //return $registrations['grade1'];
        //return $registrations[0]['grade1'];
        //return $course;
        //return $planification;


        $pdf = PDF::loadView('reports/atendence-evaluation', [
            'planification' => $planification,
            'course' => $course,
            'registrations' => $registrations,
            'institution' => $institution,
            'instructor' => $instructor,
            'user' => $user,
            'grade1' => $grade1,
            'grade2' => $grade2,
            'final_grade' => $final_grade,


        ]);

        return $pdf->stream('Asistencia-evaluacion.pdf');
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

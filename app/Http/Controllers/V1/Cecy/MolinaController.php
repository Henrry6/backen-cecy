<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Attendance\GetAttendancesByParticipantRequest;
use App\Http\Requests\V1\Cecy\Attendance\SaveDetailAttendanceRequest;
use App\Http\Requests\V1\Cecy\Certificates\DowloadCertificateByParticipantRequest;
use App\Http\Requests\V1\Cecy\Participants\GetCoursesByParticipantRequest;
use App\Http\Requests\V1\Cecy\Registrations\ShowGradesByParticipantRequest;
use App\Http\Requests\V1\Cecy\Certificates\IndexCertificateRequest;
use App\Http\Requests\V1\Cecy\Registrations\IndexRegistrationRequest;
use App\Http\Resources\V1\Cecy\Attendances\GetAttendanceByParticipantCollection;
use App\Http\Resources\V1\Cecy\Attendances\SaveDetailAttendanceResource;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceResource;
use App\Http\Resources\V1\Cecy\Participants\CoursesByParticipantCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Http\Resources\V1\Cecy\Registrations\ShowGradeByParticipantCollection;
use App\Models\Cecy\Attendance;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Planification;
use App\Models\Cecy\Registration;
use App\Models\Core\Catalogue;
use App\Models\Core\File;
use Illuminate\Http\Client\Request;

class MolinaController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('permission:view-courses')->only(['view']);
        $this->middleware('permission:view-attendances')->only(['view']);
        $this->middleware('permission:view-grades')->only(['view']);
    }*/

    //Ver todas las asistencias del estudiante
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

    //Ver todos los cursos del estudiante en el cual esta matriculado
    public function getCoursesByParticipant(GetCoursesByParticipantRequest $request)
    {
        $participant = Participant::firstWhere('user_id', $request->user()->id);
        $registrations = $participant->registrations()->where(['state' => function ($state) {
            $state->where('code', 'MATRICULADO');
        }])
            ->paginate($request->input('per_page'));

        return (new CoursesByParticipantCollection($registrations))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    public function recordsReturnedByRegistration(IndexRegistrationRequest $request)
    {
        $participant = Participant::firstWhere('user_id', $request->user()->id);
        $registrations = $participant->registrations()->get();

        return (new RegistrationResource($registrations))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    /*//Ver las notas del estudiante en curso que se encuentra
    public function showGradesByParticipant(ShowGradesByParticipantRequest $request, Registration $registration)
    {
        $participant = Participant::where('user_id', $request->user()->id)->get();
        $grades = $registration->get();
        //->paginate($request->input('per_page'));

        return (new ShowGradeByParticipantCollection($grades))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }*/

    //Descargar certificado del curso
    public function downloadCertificateByParticipant(IndexCertificateRequest $request, Registration $registration, Catalogue $catalogue, File $file)
    {
        //$participant = Participant::firstWhere('user_id', $request->user()->id);
        $certificate = $registration->certificate()->where(['state' => function ($state) {
            $state->where('code', 'APPROVED')->first();
        }]);
        return $catalogue->downloadFileCertificates($file);
    }
    // Guardar asistencia
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
}

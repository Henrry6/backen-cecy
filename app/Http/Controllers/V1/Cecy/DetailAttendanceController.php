<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Attendances\SaveDetailAttendanceRequest;
use App\Http\Requests\V1\Cecy\DetailAttendance\GetDetailAttendancesByParticipantRequest;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceResource;
use App\Http\Resources\V1\Cecy\Attendances\SaveDetailAttendanceResource;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceCollection;
use App\Models\Cecy\Attendance;
use App\Models\Cecy\DetailAttendance;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Registration;

class DetailAttendanceController extends Controller
{
    //asistencias de los estudiantes de un curso
    // DetailAttendanceController
    public function showAttedanceParticipant(Registration $registration)
    {
        $attendances =  $registration->attendances()->get;
        return (new AttendanceResource($attendances))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // Guardar asistencia
    // AttendanceController
    public function saveDetailAttendance(SaveDetailAttendanceRequest $request, DetailAttendance $detailAttendance)
    {
        $detailAttendance->type_id = $request->input('type.id');
        $detailAttendance->save();

        return (new SaveDetailAttendanceResource($detailAttendance))
            ->additional([
                'msg' => [
                    'sumary' => $detailAttendance,
                    'detail' => 'Asistencia guardada correctamente',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function getDetailAttendancesByParticipantWithOutPaginate(GetDetailAttendancesByParticipantRequest $request, DetailPlanification $detailPlanification)
    {

        $sorts = explode(',', $request->input('sort'));

        $participant = Participant::where('user_id', $request->user()->id)->first();

        $registration = Registration::where(
            [
                'detail_planification_id' => $detailPlanification->id,
                'participant_id' => $participant->id
            ]
        )->first();

        $detailAttendances = DetailAttendance::customOrderBy($sorts)
            ->registration($registration)
            ->get();


        return (new DetailAttendanceCollection($detailAttendances))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    public function getDetailAttendancesByParticipant(GetDetailAttendancesByParticipantRequest $request, DetailPlanification $detailPlanification)
    {

        $sorts = explode(',', $request->input('sort'));

        $participant = Participant::where('user_id', $request->user()->id)->first();

        $registration = Registration::where(
            [
                'detail_planification_id' => $detailPlanification->id,
                'participant_id' => $participant->id
            ]
        )->first();

        $detailAttendances = DetailAttendance::customOrderBy($sorts)
            ->registration($registration)
            ->paginate($request->input('per_page'));


        return (new DetailAttendanceCollection($detailAttendances))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function getCurrentDateDetailAttendance(GetDetailAttendancesByParticipantRequest $request, DetailPlanification $detailPlanification)
    {

        $dateToday = Date('Y-m-d');

        $attendance = Attendance::where(
            [
                'detail_planification_id' => $detailPlanification->id,
                'registered_at' => $dateToday
            ]
        )->first();

        return (new AttendanceResource($attendance))
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

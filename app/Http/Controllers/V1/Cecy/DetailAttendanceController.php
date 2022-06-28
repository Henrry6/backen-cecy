<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Attendances\SaveDetailAttendanceRequest;
use App\Http\Requests\V1\Cecy\DetailAttendance\CatalogueDetailAttendanceRequest;
use App\Http\Requests\V1\Cecy\DetailAttendance\GetDetailAttendancesByParticipantRequest;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceResource;
use App\Http\Resources\V1\Cecy\Attendances\SaveDetailAttendanceResource;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceByAttendanceCollection;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceCollection;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceResource;
use App\Models\Cecy\Attendance;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailAttendance;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Registration;

class  DetailAttendanceController extends Controller
{
    public function catalogue(CatalogueDetailAttendanceRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $detailAttendances = DetailAttendance::customOrderBy($sorts)
            ->limit(1000)
            ->get();

        return (new DetailAttendanceCollection($detailAttendances))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function changeType(DetailAttendance $detailAttendance,Catalogue $type)
    {
        $detailAttendance->type()->associate($type);
        $detailAttendance->save();

        return (new DetailAttendanceResource($detailAttendance))
            ->additional([
                'msg' => [
                    'summary' => 'Asistencia gaurdada',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    public function updateType(SaveDetailAttendanceRequest $request, DetailAttendance $detailAttendance)
    {
        $detailAttendance->type()->associate($request->input('type.id'));
        $detailAttendance->save();

        return (new SaveDetailAttendanceResource($detailAttendance))
            ->additional([
                'msg' => [
                    'summary' => 'asistencia guardada',
                    'detail' => 'Asistencia guardada correctamente',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    // loadDetailAttendancesWithOutPaginate getByRegistration en el metodo y ruta
    public function getByRegistration(GetDetailAttendancesByParticipantRequest $request, DetailPlanification $detailPlanification)
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
                    'summary' => 'consulta exitosa',
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
                    'summary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function getByAttendance(Attendance $attendance)
    {
        $detailAttendances = $attendance->detailAttendances()->get();

        return (new DetailAttendanceByAttendanceCollection($detailAttendances))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
    public function getCurrentDateDetailAttendance(GetDetailAttendancesByParticipantRequest $request, DetailPlanification $detailPlanification)
    {

        $dateToday = Date('Y-m-d');

        //return $detailPlanification;

       // echo($detailPlanification['id']);

        $attendance = Attendance::where(

            ['detail_planification_id' => $detailPlanification->id],
            [    'registered_at' => $dateToday]

        )->first();

        //echo($attendance);

        return (new AttendanceResource($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
}


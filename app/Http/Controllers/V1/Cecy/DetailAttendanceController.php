<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Attendance\UpdateDetailAttendanceRequest;
use App\Http\Requests\V1\Cecy\Certificates\ShowParticipantsRequest;
use App\Http\Resources\V1\Cecy\Authorities\DetailAttendanceCollection;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceResource;
use App\Models\Cecy\Attendance;

class DetailAttendanceController extends Controller
{
    //asistencias de los estudiantes de un curso
    // DetailAttendanceController
    public function ShowParticipantCourse(ShowParticipantsRequest $request, Attendance $attendance)
    {

        $detailAttendances = $attendance->detailAttendances()->paginate();



        return (new DetailAttendanceCollection($detailAttendances))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
    //editar o actualizar una asistencia
    // DetailAttendanceController
    public function updatDetailAttendanceTeacher(UpdateDetailAttendanceRequest $request, DetailAttendance $detailAttendance)
    {
        $detailAttendance->type_id = $request->input('type.id');

        $detailAttendance->save();

        return (new DetailAttendanceResource($detailAttendance))
            ->additional([
                'msg' => [
                    'summary' => 'Registro actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);

    }
}

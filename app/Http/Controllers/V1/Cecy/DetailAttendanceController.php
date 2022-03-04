<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceResource;

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
    //editar o actualizar una asistencia
    // DetailAttendanceController
    // public function updatDetailAttendanceTeacher(UpdateDetailAttendanceRequest $request)
    // {
    //     $detailAttendance->type_id = $request->input('type.id');

    //     $detailAttendance->save();

    //     return (new DetailAttendanceResource($detailAttendance))
    //         ->additional([
    //             'msg' => [
    //                 'summary' => 'Registro actualizado',
    //                 'detail' => '',
    //                 'code' => '200'
    //             ]
    //         ])
    //         ->response()->setStatusCode(200);

    // }
}

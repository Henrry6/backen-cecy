<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Prerequisite;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteCollection;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteResource;
use App\Http\Requests\V1\Cecy\Prerequisites\DestroyPrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\StorePrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\UpdatePrerequisiteRequest;


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
    / Guardar asistencia
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
}



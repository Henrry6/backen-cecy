<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceShowTeacherCollection;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceShowTeacherResource;
use App\Models\Cecy\Attendance;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Registration;
use Illuminate\Http\Client\Request;

class SantillanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:store-authorities_teacher')->only(['store']);
        $this->middleware('permission:update-authorities_teacher')->only(['update']);
        $this->middleware('permission:delete-authorities_teacher')->only(['destroy', 'destroys']);
    }

    //ver todas las asistencias
    public function getAttendanceTeacher(Attendance $attendance)
    {
        return (new AttendanceShowTeacherCollection($attendance))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
    //crear una asistencia a partir de las fechas y horarios de detalle planicacion.
    public function storeAttendanceTeacher(Request $request)
    {
        $attendance = new Attendance();

        $attendance->registration_id()
            ->associate(Registration::find($request->input('registration_id')));

        $attendance->type_id()
            ->associate(Catalogue::find($request->input('type_id')));

        $attendance->duration = $request->input('duration');

        $attendance->register_at = $request->input('register_at');

        $attendance->save();

        return (new AttendanceShowTeacherResource($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //ver asistencia una por una
    public function showAttendanceTeacher(Attendance $attendance)
    {
        return (new AttendanceShowTeacherCollection($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'Asistencias encontradas',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //editar o actualizar una asistencia
    public function updateAttendanceTeacher(Attendance $attendance, Request $request)
    {
        $attendance->registration_id()
            ->associate(Registration::find($request->input('registration_id')));

        $attendance->type_id()
            ->associate(Catalogue::find($request->input('type_id')));

        $attendance->duration = $request->input('duration');

        $attendance->register_at = $request->input('register_at');

        $attendance->save();

        return (new AttendanceShowTeacherResource($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'Registro actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
    //eliminar una asistencia

    public function destroyAttendanceTeacher(Attendance $attendance)
    {
        $attendance->delete();
        return (new AttendanceShowTeacherResource($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'Asistencia eliminada',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //cargar cursos por docente encargado
    public function showCourseTeacher()
    {
    }
    //subir notas de los estudiantes
    public function uploadGrades()
    {
    }

    //subir evidencia fotografica
    public function uploadPhotograficRegister()
    {
    }

    //descargar plantilla de las notas
    public function downloadTemplates()
    {
    }
}
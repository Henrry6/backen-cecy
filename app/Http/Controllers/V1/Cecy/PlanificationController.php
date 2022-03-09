<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Authorities\IndexAuthorityRequest;
use App\Http\Requests\V1\Cecy\Courses\getCoursesByResponsibleRequest;
use App\Http\Requests\V1\Cecy\KPI\Planifications\ShowKpiRequest;
use App\Http\Requests\V1\Cecy\Instructors\InstructorRequest;
use App\Http\Requests\V1\Cecy\Planifications\IndexPlanificationRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdateAssignResponsibleCecyRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdateDatesinPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetPlanificationsByCourseRequest;
use App\Http\Requests\V1\Cecy\Planifications\StorePlanificationByCourseRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdatePlanificationRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdateStatePlanificationRequest;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Planifications\Kpi\KpiPlanificationResourse;
use App\Http\Resources\V1\Cecy\Planifications\ResponsibleCoursePlanifications\PlanificationByCourseCollection;
use App\Http\Resources\V1\Cecy\Planifications\ResponsibleCoursePlanifications\PlanificationByCourseResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationCollection;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\DetailSchoolPeriod;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Planification;
use App\Models\Cecy\SchoolPeriod;
use App\Models\Core\State;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;


class PlanificationController extends Controller
{
    // Función privada que permite obtener cursos aprobados
    private function getApprovedPlanificationsId()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $planificationsTypes = Catalogue::where('type',  $catalogue['planification_state']['type'])->get();
        $planificationApproved = $planificationsTypes->where('code', $catalogue['planification_state']['approved'])->first();
        return $planificationApproved;
    }

    /**
     * Get all planifications filtered by and course
     */
    public function getPlanificationsByCourse(GetPlanificationsByCourseRequest $request, Course $course)
    {
        $sorts = explode(',', $request->sort);

        $planifications = $course->planifications()->customOrderBy($sorts)
            ->paginate($request->input('per_page'));

        return (new PlanificationByCourseCollection($planifications))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    /*
    * Asignar docente responsable de cecy de la planificación
    */
    // PlanificationController
    public function updateAssignResponsibleCecy(UpdateAssignResponsibleCecyRequest $request, Planification $planification)
    {
        $planification->responsibleCecy()->associate(Authority::find($request->input('responsibleCecy.id')));
        $planification->save();

        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    /**
     * Update start_at and ended_at and needs in planification
     */
    public function updateDatesAndNeedsInPlanification(UpdateDatesinPlanificationRequest $request, Planification $planification)
    {
        $loggedInInstructor = Instructor::where('user_id', $request->user()->id)->first();
        if (!$loggedInInstructor) {
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'No es instructor o no se encuentra registrado',
                    'code' => '400'
                ]
            ], 400);
        }

        $responsibleCourse = $planification->responsibleCourse()->first();

        if ($loggedInInstructor->id !== $responsibleCourse->id) {
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'No le pertece esta planificación',
                    'code' => '400'
                ]
            ], 400);
        }

        //validar que la planification ha culminado
        if (
            $planification->state()->first()->code === State::CULMINATED ||
            $planification->state()->first()->code === State::NOT_APPROVED
        ) {
            return response()->json([
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'La planificación ha culminado o no fue aprobada.',
                    'code' => '400'
                ]
            ], 400);
        }

        $planification->started_at = $request->input('startedAt');
        $planification->ended_at = $request->input('endedAt');
        $planification->needs = $request->input('needs');
        $planification->save();

        return (new PlanificationByCourseResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Registro actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    //Trae todos los cursos
    // PlanificationController ya esta
    public function getPlanitifications()
    {
        return "hola";
        $planifications = Planification::where(['state_id' => function ($state) {
            $state->where('code', State::APPROVED);
        }])->paginate();

        return (new CourseCollection($planifications))
            ->additional([
                'msg' => [
                    'summary' => 'Me trae los cursos',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function getPlanitification(Request $request, Planification $planification)
    {
        // GetPlanitificationRequest
        // return "hola";

        return (new PlanificationByCourseResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Consulta correcta',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    /*DDRC-C: Busca planificaciones vigentes por periodo asignadas al usuario logueado(responsable del CECY)*/
    // PlanificationController ya esta, no vale el metodo
    public function getPlanificationsByPeriodState(IndexAuthorityRequest $request)
    {

        $sorts = explode(',', $request->input('sort'));

        $authority = Authority::firstWhere('user_id', $request->user()->id);
        //verificar que el usuario logeado es una autoridad de Authority
        if (!$authority) {
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'No se encontró al usuario: no es una autoridad o no está registrado.',
                    'code' => '400'
                ]
            ], 400);
        }

        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $currentState = Catalogue::firstWhere('code', $catalogue['school_period_state']['current']);
        $schoolPeriod = SchoolPeriod::firstWhere('state_id', $currentState->id);

        $planifications = $authority->planifications()->whereHas('detailSchoolPeriod', function ($detailSchoolPeriod) use ($schoolPeriod) {
            $detailSchoolPeriod->where('school_period_id', $schoolPeriod->id);
        })->customOrderBy($sorts)
            ->get();

        // paginate($request->input('per_page'))

        return (new PlanificationCollection($planifications))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }
    /*DDRC-C: Trae una lista de nombres de cursos, paralelos y jornadas*/
    // PlanificationController ya esta, no vale el metodo.
    public function getCoursesParallelsWorkdays(getCoursesByResponsibleRequest $request)
    {
        $detailPlanifications = DetailPlanification::get();
        return $detailPlanifications;
        $sorts = explode(',', $request->sort);
        $courseParallelWorkday = Planification::customOrderBy($sorts)
            //            ->detailplanifications()
            //            ->course()
            ->get();

        //         return (new CourseParallelWorkdayResource($courseParallelWorkday))
        //             ->additional([
        //                 'msg' => [
        //                     'summary' => 'success',
        //                     'detail' => '',
        //                     'code' => '200'
        //                 ]
        //             ])->response()->setStatusCode(201);
    }

    // asignar docente responsable de curso a una planificacion ya esta
    public function storePlanificationByCourse(StorePlanificationByCourseRequest $request, Planification $planification)
    {
        $planification->responsibleCourse()->associate(Instructor::find($request->input('responsibleCourse.id')));
        $planification->course()->associate(Course::find($request->input('name')));
        $planification->participantType()->associate(Course::find($request->input('participant_type.id')));
        $planification->duration()->associate(Course::find($request->input('duration')));
        $planification->endedAt = $request->input('fin de la planificación');
        $planification->startedAt = $request->input('inicio de la planificación');
        $planification->state = $request->input('Estado de la planificacion');
        $planification->save();
        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'planificación creada',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //actualizar informacion de la planificacion ya esta
    public function updatePlanificationByCecy(UpdatePlanificationRequest $request, Planification $planification)
    {
        $loggedAuthority = Authority::where('user_id', $request->user()->id)->get();
        $planification = Planification::find($request->input('planification.id'));
        $planification->responsibleCecy()->associate(Authority::find($request->input('responsibleCecy.id')));

        $planification->course()->associate(Course::find($request->input('course.id')));
        $planification->detailSchoolPeriod()->associate(DetailSchoolPeriod::find($request->input('detail_school_period.id')));
        $planification->vicerrector()->associate(Authority::find($request->input('vicerrector.id')));
        $planification->responsibleOcs()->associate(Authority::find($request->input('responsible_ocs.id')));
        $planification->endedAt = $request->input('ended_at');
        $planification->startedAt = $request->input('started_at');
        $planification->save();
        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Actualizado correctamente',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //Asignar codigo a la planificacion ya esta
    public function assignCodeToPlanification(Planification $planification, $request)
    {
        $planification->code = $request->input('code');
        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Curso actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //Aprobacion de planificacion ya esta
    public function approvePlanification($request, Planification $planification)
    {
        $planification->state()->associate(Catalogue::FirstWhere('code', State::APPROVED));
        $planification->observation = $request->input('observation');
        $planification->save();

        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Planificacion actualizada',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    public function updateStatePlanification(UpdateStatePlanificationRequest $request, Planification $planification)
    {
        $planification->state_id = $request -> id;
        $planification ->save();

        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Estado de la planificación actualizado',
                    'detail' => 'El estado de la planificación pudo haber cambiado de posición',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    //Traer la informacion de diseño curricular (Done)
    public function curricularDesign( Planification $planification)
    {
        $planification = Planification::firstWhere('id',$planification->id);
        $course = $planification->course()->first();
        $topics = $course->topics()->first();

        //return $course;
        //return $topics;
       

            $pdf = PDF::loadView('reports/desing-curricular', [
                'planification' => $planification,
                'course' => $course,
                'topics' => $topics,
                
                
            ]);
    
            return $pdf->stream('Diseño Curricular.pdf');
        }



        //Traer la informacion de informe final del curso (Done)
    public function informeFinal( Planification $planification)
    {
        $planification = Planification::firstWhere('id',$planification->id);
        $course = $planification->course()->first();
        $topics = $course->topics()->first();



        return $course;
        //return $planification;
       

            $pdf = PDF::loadView('reports/informe-final', [
                'planification' => $planification,
                'course' => $course,
                'topics' => $topics,



                
                
            ]);
    
            return $pdf->stream('Informe final del curso.pdf');
        }

         
}



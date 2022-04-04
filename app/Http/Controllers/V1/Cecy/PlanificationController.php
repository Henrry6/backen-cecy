<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetPlanificationsByCourseRequest;
use App\Http\Requests\V1\Cecy\Authorities\IndexAuthorityRequest;
use App\Http\Requests\V1\Cecy\Planifications\StorePlanificationByCourseRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdateAssignResponsibleCecyRequest;
use App\Http\Requests\V1\Cecy\Planifications\AddNeedsOfPlanification;
use App\Http\Requests\V1\Cecy\Planifications\UpdatePlanificationRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdateStatePlanificationRequest;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Planifications\ResponsibleCoursePlanifications\PlanificationByCourseCollection;
use App\Http\Resources\V1\Cecy\Planifications\ResponsibleCoursePlanifications\PlanificationByCourseResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationCollection;
use App\Models\Authentication\User;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailSchoolPeriod;
use App\Models\Cecy\Institution;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Planification;
use App\Models\Cecy\SchoolPeriod;
use App\Models\Core\State;
use Illuminate\Http\Request;


class PlanificationController extends Controller
{
    public function __construct()
    {
    }

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
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function updateStatePlanification(UpdateStatePlanificationRequest $request, Planification $planification)
    {
        $planification->state_id = $request->id;
        $planification->save();

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

    public function updateAssignResponsibleCecy(UpdateAssignResponsibleCecyRequest $request, Planification $planification)
    {
        $planification->responsibleCecy()->associate(Authority::find($request->input('responsibleCecy.id')));
        $planification->save();

        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function addNeedsOfPlanification(AddNeedsOfPlanification $request, Planification $planification)
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

        $planification->needs = $request->input('needs');

        $planification->save();

        return (new PlanificationByCourseResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Registro actualizado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    private function getApprovedPlanificationsId()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $planificationsTypes = Catalogue::where('type',  $catalogue['planification_state']['type'])->get();
        $planificationApproved = $planificationsTypes->where('code', $catalogue['planification_state']['approved'])->first();
        return $planificationApproved;
    }

    public function getPlanificationsByCourse(GetPlanificationsByCourseRequest $request, Course $course)
    {
        $sorts = explode(',', $request->sort);

        $planifications = $course->planifications()
            ->customOrderBy($sorts)
            ->paginate($request->input('perPage'));

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
            ])
            ->response()->setStatusCode(200);
    }

    public function approvePlanification($request, Planification $planification)
    {
        $planification->state()->associate(Catalogue::FirstWhere('code', State::APPROVED));
        $planification->observation = $request->input('observation');
        $planification->save();

        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Planificación actualizada',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function curricularDesign(Planification $planification)
    {
        $planification = Planification::firstWhere('id', $planification->id);
        $course = $planification->course()->first();
        $topics = $course->topics()->first();
        $course_tec = $course->techniques_requisites['technical'];
        $course_gen = $course->techniques_requisites['general'];
        $instructor = Instructor::where('id', $planification->responsible_course_id)->first();
        //$user =  $instructor->user();
        $user = User::firstWhere('id', $instructor->user_id);

        //return $course->evaluation_mechanisms->diagnostic['tecnique'];
        //return $topics;
        //return $course;

        $pdf = PDF::loadView('reports/desing-curricular', [
            'planification' => $planification,
            'course' => $course,
            'course_tec' => $course_tec,
            'topics' => $topics,
            'course_gen' => $course_gen,
            'user' => $user,
            'instructor' => $instructor,

        ]);

        return $pdf->stream('Diseño Curricular.pdf');
    }

    public function informeFinal(Planification $planification)
    {
        $planification = Planification::firstWhere('id', $planification->id);
        $course = $planification->course()->first();
        $topics = $course->topics()->first();
        $responsiblececy = $planification->responsibleCecy()->first();
        $institution = Institution::firstWhere('id', $responsiblececy->intitution_id);

        $instructor = Instructor::where('id', $planification->responsible_course_id)->first();
        //$user =  $instructor->user();
        $user = User::firstWhere('id', $instructor->user_id);

        //return $institution;

        //return $course;
        //return $planification;

        $pdf = PDF::loadView('reports/informe-final', [
            'planification' => $planification,
            'course' => $course,
            'topics' => $topics,
            'institution' => $institution,
            'user' => $user,
            'instructor' => $instructor,

        ]);

        return $pdf->stream('Informe final del curso.pdf');
    }

    /**
     * storePlanificationByCourse 
     */
    public function storePlanificationByCourse(StorePlanificationByCourseRequest $request, Course $course)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        $toBeApproved = Catalogue::where('type',  $catalogue['planification_state']['type'])
            ->where('code',  $catalogue['planification_state']['to_be_approved'])->first();
        $instructor = Instructor::find($request->input('responsibleCourse.id')); //que estado y tipo debe ser el instructor

        $planification = new Planification();

        $planification->course()->associate($course);
        $planification->responsibleCourse()->associate($instructor);
        $planification->state()->associate($toBeApproved);

        $planification->ended_at = $request->input('endedAt');
        $planification->started_at = $request->input('startedAt');

        $planification->save();

        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Planificación creada',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }



    /**
     * updatePlanificationByCourse
     */

    public function updatePlanificationByCourse(UpdatePlanificationByCourseRequest $request, Course $course)
    {
        $course->course = $request->input('course');

        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Planificación Actualizado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    /**
     * deletePlanification
     */
    public function destroyPlanification(DestroyPlanificationRequest $planification)
    {
        $planification->delete();
        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
}

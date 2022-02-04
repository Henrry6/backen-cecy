<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\KPI\Planifications\ShowKpiRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdateAssignResponsibleCecyRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdateDatesinPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetPlanificationsByCourseRequest;
use App\Http\Requests\V1\Cecy\Planifications\StorePlanificationByCourseRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdatePlanificationRequest;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Planifications\Kpi\KpiPlanificationResourse;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationByCourseCollection;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationCollection;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailSchoolPeriod;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Planification;
use App\Models\Core\State;
use Illuminate\Database\Eloquent\Builder;

class PlanificationController extends Controller
{
    /**
     * Get all planifications filtered by and course
     */
    // PlanificationController ya esta
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
    // PlanificationController ya esta
    public function updateDatesAndNeedsInPlanification(UpdateDatesinPlanificationRequest $request, Planification $planification)
    {
        $planification->started_at = $request->input('startedAt');
        $planification->ended_at = $request->input('endedAt');
        $planification->needs = $request->input('needs');

        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'Registro actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }



    /**
     * KPI of planifications
     */
    // PlanificationController ya esta
    public function getKpi(ShowKpiRequest $request, Catalogue $state)
    {
        $planifications = Planification::withCount([
            'id' => function (Builder $query) {
                $query->where(
                    'state_id',
                    $state->id
                );
            },
        ])->get();

        return (new KpiPlanificationResourse($planifications[0]))
            ->additional([
                'msg' => [
                    'summary' => 'success',
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
        $planifications = Planification::where(['state' => function ($state) {
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

    /*DDRC-C: Busca planificaciones vigentes por periodo asignadas al usuario logueado(responsable del CECY)*/
    // PlanificationController ya esta
    public function getPlanificationsByPeriodState(InstructorRequest $request)
    {
        $instructor = Instructor::FirstWhere('user_id', $request->user()->id)->get();
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $planifications = $instructor
            ->planifications()
            ->period($request->input('period.id'))
            ->where('state', $catalogue['planification_state']['approved'])
            ->paginate($request->input('per_page'));

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
    // PlanificationController ya esta
    public function getCoursesParallelsWorkdays(getCoursesByResponsibleRequest $request)
    {
        $sorts = explode(',', $request->sort);
        $courseParallelWorkday = Planification::customOrderBy($sorts)
//            ->detailplanifications()
//            ->course()
            ->get();

        return (new CourseParallelWorkdayResource($courseParallelWorkday))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(201);
    }

    // asignar docente responsable de curso a una planificacion ya esta
    public function storePlanificationByCourse(StorePlanificationByCourseRequest $request, Planification $planification)
    {
        $planification ->responsibleCourse()->associate(Instructor::find($request->input('responsibleCourse.id')));
        $planification->course()->associate(Course::find($request->input('name')));
        $planification->participant_type()->associate(Course::find($request->input('participant_type.id')));
        $planification->duration()->associate(Course::find($request->input('duration')));
        $planification->ended_at = $request->input('fin de la planificación');
        $planification->started_at = $request->input('inicio de la planificación');
        $planification->state_id = $request->input('Estado de la planificacion');
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
        $planification->detail_school_period()->associate(DetailSchoolPeriod::find($request->input('detail_school_period.id')));
        $planification->vicerrector()->associate(Authority::find($request->input('vicerrector.id')));
        $planification->responsible_ocs()->associate(Authority::find($request->input('responsible_ocs.id')));
        $planification->ended_at = $request->input('ended_at');
        $planification->started_at = $request->input('started_at');
        $planification->save();
        return (new PlanificationResource ($planification))
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

}



<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\KPI\Planifications\ShowKpiRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdateAssignResponsibleCecyRequest;
use App\Http\Requests\V1\Cecy\Planifications\UpdateDatesinPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetPlanificationsByCourseRequest;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Planifications\Kpi\KpiPlanificationResourse;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationByCourseCollection;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationResource;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\Planification;
use App\Models\Core\State;
use Illuminate\Database\Eloquent\Builder;

class PlanificationController extends Controller
{
    /**
     * Get all planifications filtered by and course
     */
    // PlanificationController
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
    // PlanificationController
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
    // PlanificationController
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
    // PlanificationController
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
    // PlanificationController
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
    // PlanificationController
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
}

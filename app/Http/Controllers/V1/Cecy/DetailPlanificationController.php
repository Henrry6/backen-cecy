<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\DetailPlanifications\UpdateDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\DeleteDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\DestroysDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetDetailPlanificationsByPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetDetailPlanificationsByResponsibleCourseRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\RegisterDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\ShowDetailPlanificationRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\Topic;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Http\Resources\V1\Cecy\Topics\TopicResource;
use App\Http\Resources\V1\Cecy\Topics\TopicCollection;
use App\Http\Requests\V1\Cecy\Topics\StoreTopicRequest;
use App\Http\Requests\V1\Cecy\Topics\UpdateTopicRequest;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Classroom;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Planification;
use App\Models\Core\State;

class DetailPlanificationController extends Controller
{
    public function __construct()
    {
    }
    /*
        Obtener los horarios de cada paralelo dado un curso
    */
    // DetailController (done) =>conflicto en controlador

    public function getDetailPlanificationsByCourse(Course $course) //hecho
    {

        $planification = $course->planifications()->get();
        $detailPlanification = $planification
            ->detailPlanifications();
        return (new DetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }



    /**
     * Get all detail planifications filtered by responsible_course
     */
    // DetailPlanificationController
    public function getDetailPlanificationsByResponsibleCourse(GetDetailPlanificationsByResponsibleCourseRequest $request) 
    {
        $responsibleCourse = Instructor::where('user_id', $request->user()->id)->get();

        $detailPlanifications = $responsibleCourse
            ->detailPlanifications()
            ->paginate($request->input('per_page'));

        return (new DetailPlanificationCollection($detailPlanifications))
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
     * Get all detail planifications filtered by planification
     */
    // DetailPlanificationController  
    public function getDetailPlanificationsByPlanification(GetDetailPlanificationsByPlanificationRequest $request) //hecho
    {
        // $sorts = explode(',', $request->sort);

        // $detailPlanifications = DetailPlanification::customOrderBy($sorts)
        // ->planification($request->input('planification.id'))
        // ->paginate($request->input('per_page'));

        $planification = Planification::find($request->input('planification.id'));
        $detailPlanifications = $planification
            ->detailPlanifications()
            ->paginate($request->input('per_page'));

        return (new DetailPlanificationCollection($detailPlanifications))
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
     * Store a detail planification record
     */
    // DetailPlanificationController
    public function registerDetailPlanification(RegisterDetailPlanificationRequest $request) //hecho
    {
        return 'works!';
        $loggedInInstructor = Instructor::where('user_id', $request->user()->id)->get();

        $planification = Planification::find($request->input('planification.id'));
        $responsibleCourse = $planification->reponsibleCourse();

        // validar que la planification le pertenezca al docente logeado
        // if ($loggedInInstructor->id !== $responsibleCourse->id) {
        //     return response()->json([
        //         'msg' => [
        //             'summary' => 'No le pertenece esta planificación',
        //             'detail' => '',
        //             'code' => '400'
        //         ]
        //     ], 400);
        // }

        //validar que la planification ha culminado
        if ($planification->state()->first()->code === State::CULMINATED) {
            return response()->json([
                'msg' => [
                    'summary' => 'La planificación ha culminado.',
                    'detail' => '',
                    'code' => '400'
                ]
            ], 400);
        }

        $state = Catalogue::firstWhere('code', State::TO_BE_APPROVED);
        $classroom = Classroom::find($request->input('classroom.id'));
        $days = Catalogue::find($request->input('day.id'));
        $workday = Catalogue::find($request->input('workday.id'));
        $parallel = Catalogue::find($request->input('parallel.id'));

        $detailPlanification = new DetailPlanification();

        $detailPlanification->state()->associate($state);
        $detailPlanification->classroom()->associate($classroom);
        $detailPlanification->day()->associate($days);
        $detailPlanification->planification()->associate($planification);
        $detailPlanification->workday()->associate($workday);
        $detailPlanification->parallel()->associate($parallel);

        $detailPlanification->ended_time = $request->input('endedTime');
        $detailPlanification->started_time = $request->input('startedTime');

        if ($request->has('observations')) {
            $detailPlanification->observations = $request->input('observations');
        }

        $detailPlanification->save();

        return (new DetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    /**
     * Return a detailPlanification record
     */
    // DetailPlanificationController
    public function showDetailPlanification(ShowDetailPlanificationRequest $request, DetailPlanification $detailPlanification) //hecho
    {
        return (new DetailPlanificationResource($detailPlanification))
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
     * Update a detail planification record
     */
    // DetailPlanificationController
    public function updateDetailPlanification(UpdateDetailPlanificationRequest $request, DetailPlanification $detailPlanification) //hecho
    {
        $loggedInstructor = Instructor::where('user_id', $request->user()->id)->get();
        $planification = Planification::find($request->input('planification.id'));
        $responsibleCourse = $planification->reponsibleCourse();

        if ($loggedInstructor->id !== $responsibleCourse->id) {
            return response()->json([
                'msg' => [
                    'summary' => 'No le pertece esta planificación',
                    'detail' => '',
                    'code' => '400'
                ]
            ], 400);
        }


        $classroom = Classroom::find($request->input('classroom.id'));
        $days = Catalogue::find($request->input('day.id'));
        $planification = Planification::find($request->input('planification.id'));
        $workday = Catalogue::find($request->input('workday.id'));
        $parallel = Catalogue::find($request->input('parallel.id'));

        $detailPlanification->classroom()->associate($classroom);
        $detailPlanification->day()->associate($days);
        $detailPlanification->planification()->associate($planification);
        $detailPlanification->workday()->associate($workday);
        $detailPlanification->parallel()->associate($parallel);

        $detailPlanification->ended_time = $request->input('endedTime');
        $detailPlanification->started_time = $request->input('startedTime');

        if ($request->has('observations')) {
            $detailPlanification->observations = $request->input('observations');
        }

        $detailPlanification->save();

        return (new DetailPlanificationResource($detailPlanification))
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
     * Delete a detail planification record
     */
    // DetailPlanificationController
    public function deleteDetailPlanification(DeleteDetailPlanificationRequest $request, DetailPlanification $detailPlanification) //hecho
    {
        $detailPlanification->delete();

        return (new DetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => 'Registro eliminado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    //actualizar informacion del detalle planificación
    public function updatedetailPlanificationByCecy(UpdateDetailPlanificationRequest $request) //hecho
    {
        $loggedAuthority = Authority::where('user_id', $request->user()->id)->get();
        $classroom = Classroom::find($request->input('classroom.id'));
        $days = Catalogue::find($request->input('day.id'));
        $planification = Planification::find($request->input('planification.id'));
        $workday = Catalogue::find($request->input('workday.id'));
        $parallel = Catalogue::find($request->input('parallel.id'));

        $detailPlanification = DetailPlanification::find($request->input('detailPlanification.id'));

        $detailPlanification->classroom()->associate($classroom);
        $detailPlanification->planification()->associate($planification);
        $detailPlanification->day()->associate($days);
        $detailPlanification->workday()->associate($workday);
        $detailPlanification->parallel()->associate($parallel);


        $detailPlanification->days_number = $request->input('days_number');
        $detailPlanification->ended_at = $request->input('ended_at');
        $detailPlanification->plan_ended_at = $request->input('plan_ended_at');
        $detailPlanification->started_at = $request->input('started_at');
        $detailPlanification->save();

        return (new DetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => 'Actualizado correctamente',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    /**
     * Delete a detail planification record
     */
    // DetailPlanificationController
    public function destroysDetailPlanifications(DestroysDetailPlanificationRequest $request) //hecho
    {
        return 'works!';
        $detailPlanifications = DetailPlanification::whereIn('id', $request->input('ids'))->get();
        DetailPlanification::destroy($request->input('ids'));

        return (new DetailPlanificationCollection($detailPlanifications))
            ->additional([
                'msg' => [
                    'summary' => 'Registros eliminados',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
}

<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\DetailPlanifications\CatalogueDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\DeleteDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\DestroysDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetDetailPlanificationsByPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\RegisterDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\ShowDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\UpdateDetailPlanificationRequest as UpdateDetailPlanification;
use App\Http\Requests\V1\Cecy\DetailPlanifications\UpdateDetailPlanificationRequest;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\ResponsibleCourseDetailPlanifications\DetailPlanificationCollection as ResponsibleCourseDetailPlanificationCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\ResponsibleCourseDetailPlanifications\DetailPlanificationResource as ResponsibleCourseDetailPlanificationResource;
use App\Models\Core\State;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Classroom;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Planification;
//use Illuminate\Support\Facades\Validator;
//use Illuminate\Validation\Rule;
//use Symfony\Component\Translation\Exception\NotFoundResourceException;

class DetailPlanificationController extends Controller
{
    public function __construct()
    {
    }

    public function catalogue(CatalogueDetailPlanificationRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $detailPlanifications =  DetailPlanification::customOrderBy($sorts)
            ->observation($request->input('search'))
            ->limit(1000)
            ->get();

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
                    'summary' => 'Éxito',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    /**
     * Get all detail planifications filtered by planification
     */
    public function getDetailPlanificationsByPlanification(GetDetailPlanificationsByPlanificationRequest $request, Planification $planification)
    {
        $sorts = explode(',', $request->sort);

        $detailPlanifications = $planification
            ->customOrderBy($sorts)
            ->detailPlanifications()
            ->paginate($request->input('perPage'));


        return (new ResponsibleCourseDetailPlanificationCollection($detailPlanifications))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    /**
     * Store a detail planification record
     */
    public function storeDetailPlanification(RegisterDetailPlanificationRequest $request)
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

        $planification = Planification::find($request->input('planification.id'));
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
            $planification->state()->first()->code === State::APPROVED
        ) {
            return response()->json([
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'La planificación ha culminado o ya fue aprobada.',
                    'code' => '400'
                ]
            ], 400);
        }

        $state = Catalogue::firstWhere('code', State::TO_BE_APPROVED);
        $classroom = Classroom::find($request->input('classroom.id'));
        $day = Catalogue::find($request->input('day.id'));
        $workday = Catalogue::find($request->input('workday.id'));
        $parallel = Catalogue::find($request->input('parallel.id'));

        $detailPlanification = new DetailPlanification();

        $detailPlanification->state()->associate($state);
        $detailPlanification->classroom()->associate($classroom);
        $detailPlanification->day()->associate($day);
        $detailPlanification->planification()->associate($planification);
        $detailPlanification->workday()->associate($workday);
        $detailPlanification->parallel()->associate($parallel);

        $detailPlanification->ended_time = $request->input('endedTime');
        $detailPlanification->started_time = $request->input('startedTime');

        if ($request->has('observation')) {
            $detailPlanification->observation = $request->input('observation');
        }

        $detailPlanification->save();

        return (new ResponsibleCourseDetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => 'Registro Creado',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    /**
     * Return a detailPlanification record
     */
    public function showDetailPlanification(ShowDetailPlanificationRequest $request, DetailPlanification $detailPlanification)
    {
        return (new ResponsibleCourseDetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    /**
     * Update a detail planification record
     */
    public function updateDetailPlanification(UpdateDetailPlanification $request, DetailPlanification $detailPlanification)
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

        // $planification = $loggedInInstructor->planifications()->get();
        // $planification = Planification::find($request->input('planification.id'));
        $planification = $detailPlanification->planification()->first();
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

        if (
            $planification->state()->first()->code === State::CULMINATED ||
            $planification->state()->first()->code === State::APPROVED
        ) {
            return response()->json([
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'La planificación ha culminado o ya fue aprobada.',
                    'code' => '400'
                ]
            ], 400);
        }

        $classroom = Classroom::find($request->input('classroom.id'));
        $day = Catalogue::find($request->input('day.id'));
        $workday = Catalogue::find($request->input('workday.id'));
        $parallel = Catalogue::find($request->input('parallel.id'));

        $detailPlanification->classroom()->associate($classroom);
        $detailPlanification->day()->associate($day);
        $detailPlanification->planification()->associate($planification);
        $detailPlanification->workday()->associate($workday);
        $detailPlanification->parallel()->associate($parallel);

        $detailPlanification->ended_time = $request->input('endedTime');
        $detailPlanification->started_time = $request->input('startedTime');

        if ($request->has('observation')) {
            $detailPlanification->observation = $request->input('observation');
        }

        $detailPlanification->save();

        return (new ResponsibleCourseDetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => 'Registro actualizado',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    /**
     * Delete a detail planification record
     */
    public function deleteDetailPlanification(DeleteDetailPlanificationRequest $request, DetailPlanification $detailPlanification)
    {
        $planification = $detailPlanification->planification()->first();
        $responsibleCourse = $planification->responsibleCourse()->first();

        $loggedInInstructor = Instructor::where('user_id', $request->user()->id)->first();
        if (!$loggedInInstructor) {
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'No es instructor o no se encuentra registrado',
                    'code' => '400'
                ]
            ], 400); //revisar ->response()->setStatusCode(400)
        }

        if ($loggedInInstructor->id !== $responsibleCourse->id) {
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'No le pertece esta planificación',
                    'code' => '400'
                ]
            ], 400); //revisar ->response()->setStatusCode(400)
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
            ], 400); //revisar ->response()->setStatusCode(400)
        }

        $detailPlanification->delete();

        return (new ResponsibleCourseDetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => 'Registro eliminado',
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
        $day = Catalogue::find($request->input('day.id'));
        $planification = Planification::find($request->input('planification.id'));
        $workday = Catalogue::find($request->input('workday.id'));
        $parallel = Catalogue::find($request->input('parallel.id'));

        $detailPlanification = DetailPlanification::find($request->input('detailPlanification.id'));

        $detailPlanification->classroom()->associate($classroom);
        $detailPlanification->planification()->associate($planification);
        $detailPlanification->day()->associate($day);
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
            ])->response()->setStatusCode(200);
    }

    /**
     * Delete some detail planification records
     */
    public function destroysDetailPlanifications(DestroysDetailPlanificationRequest $request)
    {
        $detailPlanification = DetailPlanification::find($request->ids[0]);
        $planification = $detailPlanification->planification()->first();
        // return $planification;
        $responsibleCourse = $planification->responsibleCourse()->first();

        $loggedInInstructor = Instructor::where('user_id', $request->user()->id)->first();
        if (!$loggedInInstructor) {
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'No es instructor o no se encuentra registrado',
                    'code' => '400'
                ]
            ], 400); //revisar ->response()->setStatusCode(400)
        }

        if ($loggedInInstructor->id !== $responsibleCourse->id) {
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'No le pertece esta planificación',
                    'code' => '400'
                ]
            ], 400); //revisar ->response()->setStatusCode(400)
        }

        //validar que la planification ha culminado
        if (
            $planification->state()->first()->code === State::CULMINATED ||
            $planification->state()->first()->code === State::APPROVED
        ) {
            return response()->json([
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'La planificación ha culminado o ya fue aprobada.',
                    'code' => '400'
                ]
            ], 400); //revisar ->response()->setStatusCode(400)
        }
        $detailPlanifications = DetailPlanification::whereIn('id', $request->input('ids'))->get();
        DetailPlanification::destroy($request->input('ids'));

        return (new ResponsibleCourseDetailPlanificationCollection($detailPlanifications))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => 'Registros eliminados',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
}

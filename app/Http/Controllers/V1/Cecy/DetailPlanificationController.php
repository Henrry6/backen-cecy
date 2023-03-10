<?php

namespace App\Http\Controllers\V1\Cecy;


use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Courses\getCoursesByResponsibleRequest;
use App\Http\Requests\V1\Cecy\DetailPlanifications\AssignInstructorsRequest;
use App\Http\Requests\V1\Cecy\DetailPlanifications\CatalogueDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\DetailPlanifications\IndexDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\DetailPlanifications\UpdateDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\Planifications\IndexPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\DeleteDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\DestroysDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\RegisterDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\ShowDetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\UpdateDetailPlanificationRequest as UpdateDetailPlanification;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetDetailPlanificationsByPlanificationRequest;
use App\Http\Requests\V1\Core\Files\DestroysFileRequest;
use App\Http\Requests\V1\Core\Files\IndexFileRequest;
use App\Http\Requests\V1\Core\Files\UpdateFileRequest;
use App\Http\Requests\V1\Core\Files\UploadFileRequest;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationByInstructorCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\ResponsibleCourseDetailPlanifications\DetailPlanificationCollection as ResponsibleCourseDetailPlanificationCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\ResponsibleCourseDetailPlanifications\DetailPlanificationResource as ResponsibleCourseDetailPlanificationResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\ResponsibleCourseDetailPlanifications\DetailPlanificationCollection as ResponsibleCourseDetailPlanificationsCollection;

use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationParticipants\DetailPlanificationParticipantCollection;
use App\Models\Authentication\User;
use App\Models\Core\File;
use App\Models\Core\State;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Classroom;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Planification;
use App\Models\Cecy\Registration;

class DetailPlanificationController extends Controller
{
    public function __construct()
    {
    }

    public function index(IndexDetailPlanificationRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $detailPlanifications = DetailPlanification::customOrderBy($sorts)
            ->observation($request->input('search'))
            ->paginate($request->input('perPage'));

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

    public function catalogue(CatalogueDetailPlanificationRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $detailPlanifications = DetailPlanification::customOrderBy($sorts)
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

    public function store(RegisterDetailPlanificationRequest $request)
    {
        $planification = Planification::find($request->input('planification.id'));

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
                    'summary' => '??xito',
                    'detail' => 'Registro Creado',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    private function checkHours(DetailPlanification $detailPlanification, Planification $planification): bool
    {
        $detailPlanifications = DetailPlanification::where('planification_id', $planification->id)
            ->where('state_id', Catalogue::firstWhere('code', State::TO_BE_APPROVED)->id)
            ->get();

        foreach ($detailPlanifications as $detailPlanification) {
            // if ($detailPlanification->started_time <= $s && $detailPlanification->ended_time >= $e) {
            // return false;
            // }
        }
        return true;
    }

    public function show(ShowDetailPlanificationRequest $request, DetailPlanification $detailPlanification)
    {
        return (new ResponsibleCourseDetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => '??xito',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }


    public function update(UpdateDetailPlanification $request, DetailPlanification $detailPlanification)
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

        $planification = $detailPlanification->planification()->first();
        $responsibleCourse = $planification->responsibleCourse()->first();

        if ($loggedInInstructor->id !== $responsibleCourse->id) {
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'No le pertece esta planificaci??n',
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
                    'summary' => '??xito',
                    'detail' => 'Registro actualizado',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }


    public function destroy(DetailPlanification $detailPlanification)
    {
        $detailPlanification->delete();

        return (new ResponsibleCourseDetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => '??xito',
                    'detail' => 'Registro eliminado',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }


    public function destroys(DestroysDetailPlanificationRequest $request)
    {
        // $detailPlanification = DetailPlanification::find($request->ids[0]);
        // $planification = $detailPlanification->planification()->first();
        // $responsibleCourse = $planification->responsibleCourse()->first();

        // $loggedInInstructor = Instructor::where('user_id', $request->user()->id)->first();
        // if (!$loggedInInstructor) {
        //     return response()->json([
        //         'data' => '',
        //         'msg' => [
        //             'summary' => 'Error',
        //             'detail' => 'No es instructor o no se encuentra registrado',
        //             'code' => '400'
        //         ]
        //     ], 400);
        // }

        // if ($loggedInInstructor->id !== $responsibleCourse->id) {
        //     return response()->json([
        //         'data' => '',
        //         'msg' => [
        //             'summary' => 'Error',
        //             'detail' => 'No le pertece esta planificaci??n',
        //             'code' => '400'
        //         ]
        //     ], 400);
        // }

        //validar que la planification ha culminado
        // if (
        //     $planification->state()->first()->code === State::CULMINATED ||
        //     $planification->state()->first()->code === State::APPROVED
        // ) {
        //     return response()->json([
        //         'msg' => [
        //             'summary' => 'Error',
        //             'detail' => 'La planificaci??n ha culminado o ya fue aprobada.',
        //             'code' => '400'
        //         ]
        //     ], 400);
        // }
        $detailPlanifications = DetailPlanification::whereIn('id', $request->input('ids'))->get();
        DetailPlanification::destroy($request->input('ids'));

        return (new ResponsibleCourseDetailPlanificationCollection($detailPlanifications))
            ->additional([
                'msg' => [
                    'summary' => '??xito',
                    'detail' => 'Registros eliminados',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    /**
     * Assign instructors to detail planifications.
     */
    public function assignInstructors(AssignInstructorsRequest $request, DetailPlanification $detailPlanification)
    {
        $instructors = Instructor::whereIn('id', $request->input('ids'))->with('user')->get();
        $courseProfileId = $detailPlanification->load('planification.course.courseProfile')
            ->planification->course->courseProfile->id;
        foreach ($instructors as $instructor) {
            throw_if(
                $instructor->hasCourseProfile($courseProfileId) === 0,
                \Exception::class,
                "Instructor {$instructor->user['name']} no tiene el perfil del curso",
                400
            );
        }
        $detailPlanification->instructors()->sync($request->input('ids'));

        return (new ResponsibleCourseDetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => '??xito',
                    'detail' => 'Asignaci??n actualizada',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
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
                    'summary' => '??xito',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    public function updateDetailPlanificationProposal(UpdateDetailPlanificationRequest $request)
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

    public function getParticipantsByDetailPlanification(IndexDetailPlanificationRequest $request, DetailPlanification $detailPlanification)
    {
        // DDRC-C: obtiene una lista de participantes inscritos a un curso dado el detalle de la planificaci??n
        $sorts = explode(',', $request->input('sort'));

        $participants = $detailPlanification->registrations()
            ->participantUsername($request->input('search'))
            ->customOrderBy($sorts)
            ->paginate($request->input('per_page'));

        return (new DetailPlanificationParticipantCollection($participants))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    //obtener los cursos asignados a un isntructor logueado (Done)
    public function getInstructorByCourses(getCoursesByResponsibleRequest $request)
    {
        $instructor = Instructor::FirstWhere('user_id', $request->user()->id)->first();
        $detailPlanification = $instructor->detailPlanifications()->get();
//        $instructor = Instructor::FirstWhere('user_id', $request->user()->id)->first();
//        $courseId = Course::where('name','LIKE', "%{$request->input('search')}%")->first();
//        $detailPlanification = $instructor->detailPlanifications()->whereHas('planification', function($planification)use($courseId){
//            $planification->where('course_id','=',$courseId);
//        })->get();


        return (new DetailPlanificationByInstructorCollection($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => 'Consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // Files
    public function indexFiles(IndexFileRequest $request, DetailPlanification $detailPlanification)
    {
        return $detailPlanification->indexFiles($request);
    }

    public function uploadFile(UploadFileRequest $request, DetailPlanification $detailPlanification)
    {
        return $detailPlanification->uploadFile($request);
    }

    public function downloadFile(DetailPlanification $detailPlanification, File $file)
    {
        return $detailPlanification->downloadFile($file);
    }

    public function showFile(DetailPlanification $detailPlanification, File $file)
    {
        return $detailPlanification->showFile($file);
    }

    public function updateFile(UpdateFileRequest $request, DetailPlanification $detailPlanification, File $file)
    {
        return $detailPlanification->updateFile($request, $file);
    }

    public function destroyFile(DetailPlanification $detailPlanification, File $file)
    {
        return $detailPlanification->destroyFile($file);
    }

    public function destroyFiles(DetailPlanification $detailPlanification, DestroysFileRequest $request)
    {
        return $detailPlanification->destroyFiles($request);
    }
}

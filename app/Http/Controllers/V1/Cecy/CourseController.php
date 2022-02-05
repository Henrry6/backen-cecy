<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByCategoryRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByCoordinatorCecyRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByNameRequest;
use App\Http\Requests\V1\Cecy\Courses\getCoursesByResponsibleRequest;
use App\Http\Requests\V1\Cecy\Courses\IndexCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByCareerRequest;
use App\Http\Requests\V1\Cecy\Courses\UpdateCourseGeneralDataRequest;
use App\Http\Requests\V1\Cecy\Courses\StoreCourseNewRequest;
use App\Http\Requests\V1\Cecy\Planifications\GetPlanificationByResponsableCourseRequest;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationCollection;
use Illuminate\Http\Request;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Requests\V1\Cecy\Courses\UpdateCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\UploadCertificateOfApprovalRequest;
use App\Http\Requests\V1\Cecy\Planifications\GetDateByshowYearScheduleRequest;
use App\Http\Requests\V1\Cecy\Planifications\IndexPlanificationRequest;
use App\Http\Resources\V1\Cecy\Courses\CourseByCoordinatorCecyCollection;
use App\Http\Resources\V1\Cecy\Courses\CoursePublicPrivateCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationInformNeedResource;
use App\Http\Resources\V1\Cecy\Planifications\InformCourseNeedsResource;
use App\Http\Resources\V1\Cecy\Prerequisites\CoursesByResponsibleCollection;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Planification;
use App\Models\Core\File;
use App\Models\Core\Image;
use App\Models\Core\State;
use App\Models\Core\Career;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:store-catalogues')->only(['store']);
        // $this->middleware('permission:update-catalogues')->only(['update']);
        // $this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    }

    // Función privada que permite obtener cursos aprobados
    private function getApprovedCourses()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $coursesTypes = Catalogue::where('type',  $catalogue['course_state']['type'])->get();
        $courseApproved = $coursesTypes->where('code', $catalogue['course_state']['approved'])->first();
        return ($courseApproved);
    }
    // Obtiene los cursos públicos aprobados (Done)
    public function getPublicCourses(IndexCourseRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $courseApproved = $this->getApprovedCourses();
        $courses =  Course::customOrderBy($sorts)
            ->public(true)
            ->state($courseApproved->id)
            ->get();

        return (new CoursePublicPrivateCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // Obtiene los cursos públicos aprobados por categoria (Done)
    public function getPublicCoursesByCategory(GetCoursesByCategoryRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $courseApproved = $this->getApprovedCourses();
        $courses =  Course::customOrderBy($sorts)
            ->category($request->input('category.id'))
            ->public(true)
            ->state($courseApproved->id)
            ->get();

        return (new CoursePublicPrivateCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // Obtiene los cursos públicos aprobados por nombre (Done)
    public function getPublicCoursesByName(GetCoursesByNameRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $courseApproved = $this->getApprovedCourses();
        $courses =  Course::customOrderBy($sorts)
            ->name($request->input('name'))
            ->public(true)
            ->state($courseApproved->id)
            ->get();

        return (new CoursePublicPrivateCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // Obtiene los cursos privados aprobados por tipo de participante
    public function getPrivateCoursesByParticipantType(IndexPlanificationRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));
        $courseApproved = $this->getApprovedCourses();
        $catalogues = Catalogue::get();

        $participant = Participant::where('user_id', $request->user()->id)->first();
        $typeParticipant = $participant->type_id;

        // $participants_courses = $catalogues->courses()->>where([['catalogue_id', $typeParticipant],['state_id', $courseApproved]])->get();

        foreach ($catalogues as $catalogue) {
            echo ($catalogue->courses()
                ->where(
                    [
                        ['catalogue_id', 41],
                        // ['state_id', $courseApproved->id]
                    ]
                )
                ->get());
        }


        // return (new CoursePublicPrivateCollection($allowedCourses))
        //     ->additional([
        //         'msg' => [
        //             'summary' => 'success',
        //             'detail' => '',
        //             'code' => '200'
        //         ]
        //     ])->response()->setStatusCode(200);
    }

    // Obtiene los cursos privados aprobados por tipo de participante y filtrados por categoria
    public function getPrivateCoursesByCategory(getCoursesByCategoryRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $courses = Course::customOrderBy($sorts)
            ->category($request->input('category.id'))
            ->paginate($request->input('per_page'));

        $private_courses = $courses->where('public', false)->get();


        return (new CoursePublicPrivateCollection($private_courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // Obtiene los cursos privados aprobados por tipo de participante y filtrados por nombre
    public function getPrivateCoursesByName(getCoursesByNameRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $courses = Course::customOrderBy($sorts)
            ->name($request->input('name'))
            ->paginate($request->input('per_page'));

        $private_courses = $courses->where('public', false)->get();

        return (new CoursePublicPrivateCollection($private_courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // Actualiza la informacion del diseño curricular
    public function updateCourse(UpdateCourseRequest $request, Course $course)
    {
        $course->area()->associate(Catalogue::find($request->input('area.id')));
        $course->speciality()->associate(Catalogue::find($request->input('speciality.id')));
        $course->alignment = $request->input('alignment');
        $course->objective = $request->input('objective');
        $course->techniques_requisites = $request->input('techniquesRequisites');
        $course->teaching_strategies = $request->input('teachingStrategies');
        $course->evaluation_mechanism = $request->input('evaluationMechanisms');
        $course->learning_environment = $request->input('learningEnvironments');
        $course->practice_hours = $request->input('practiceHours');
        $course->theory_hours = $request->input('theoryHours');
        $course->bibliographies = $request->input('bibliographies');
        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //visualizar todos los cursos
    public function getCourses()
    {
        $courses = Course::get();

        return (new CourseCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'Me trae los cursos',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    //obtener los cursos asignados a un docente responsable logueado
    public function getCoursesByResponsibleCourse(getCoursesByResponsibleRequest $request)
    {
        $instructor = Instructor::FirstWhere('user_id', $request->user()->id);
        $courses = $instructor->courses()->get();

        return (new CoursesByResponsibleCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'Consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //Trae toda la info de un curso seleccionado
    public function show(Course $course)
    {
        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //actualiza datos generales de un curso seleccionado
    public function updateGeneralInformationCourse(UpdateCourseGeneralDataRequest $request, Course $course)
    {
        $course->category()->associate(Catalogue::find($request->input('category.id')));
        $course->certifiedType()->associate(Catalogue::find($request->input('certifiedType.id')));
        $course->courseType()->associate(Catalogue::find($request->input('courseType.id')));
        $course->modality()->associate(Catalogue::find($request->input('modality.id')));
        $course->speciality()->associate(Catalogue::find($request->input('speciality.id')));
        $course->abbreviation = $request->input('abbreviation');
        $course->duration = $request->input('duration');
        $course->needs = $request->input('needs');
        $course->project = $request->input('project');
        $course->sumary = $request->input('sumary');
        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //Obtener cursos y Filtrarlos por peridos lectivos , carrera o estado
    public function getCoursesByCoordinator(GetCoursesByCoordinatorCecyRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $courses = Course::customOrderBy($sorts)
            ->career(($request->input('career.id')))
            ->academicPeriod(($request->input('academicPeriod.id')))
            ->state(($request->input('state.id')))
            ->paginate($request->input('per_page'));

        return (new CourseByCoordinatorCecyCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => '',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    //MOSTRAR LOS KPI DE CURSOS APROBADOS, POR APROBAR Y EN PROCESO
    public function getCoursesKPI(Request $request)
    {
        $courses = DB::table('courses as cr')
            ->join('catalogue as ct', 'ct.id', '=', 'cr.state_id')
            ->where('ct.name', '=', 'APPROVED, TO_BE_APPROVED, IN_PROCESS')
            ->select(DB::raw('count(*) as course_count'))
            ->first()
            ->paginate($request->input('per_page'));


        echo $courses->course_count;
    }

    //Asignar código al curso
    public function assignCodeToCourse($request, Course $course)
    {
        $course->code = $request->input('code');
        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Curso actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    // Ingresar el motivo del por cual el curso no esta aprobado
    public function approveCourse($request, Course $course)
    {
        $course->state()->associate(Catalogue::firstWhere('code', State::APPROVED));
        $course->observation = $request->input('observation');
        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Curso actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function showInformCourseNeeds(Course $course)
    {
        //trae un informe de nececidades de una planificacion, un curso en especifico por el docente que se logea


        $planification = $course->planifications()->first();
        //            ->detailPlanifications()
        //            ->instructors()
        //            ->classrooms();
        /*         ->planifications() */
        //->course()

        /*             $planification = $course->planifications()->instructors()->users()->get()
                    ->detailPlanifications()
                    ->classrooms(); */

        $data = new InformCourseNeedsResource($planification);
    }

    public function showYearSchedule(GetDateByshowYearScheduleRequest $request)
    {
        //trae todos los cursos planificados de un año en especifico
        $year = Planification::whereYear('started_at', $request->input('startedAt'))->get();

        $planificacion = $year
            ->instructors()
            ->detailPlanifications()
            ->classrooms()
            ->planifications()
            ->courses()
            ->paginate($request->input('per_page'));

        return (new DetailPlanificationInformNeedResource($planificacion))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function showCurricularDesign(getCoursesByNameRequest $request, Course $course)
    {
        // trae la informacion de diseño curricular

        $planification = $course->planifications()->get()
            ->detailPlanifications()
            ->planifications()
            ->course()
            ->paginate($request->input('per_page'));

        return (new InformCourseNeedsResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    public function showFinalCourseReport(getCoursesByNameRequest $request, Course $course)
    {
        // trae la informacion del informe final del curso

        $course = Course::where('course_id', $request->course()->id)->get();

        $detailPlanifications = $course
            ->detailPlanifications()
            ->planifications()
            ->instructors()
            ->course()
            ->registration()
            ->paginate($request->input('per_page'));


        return (new InformCourseNeedsResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //cursos de un docente instructor
    public function getCoursesByInstructor(GetPlanificationByResponsableCourseRequest $request)
    {

        $instructor = Instructor::FirstWhere('user_id', $request->user()->id);
        $planifications = $instructor->planifications()->get();

        return (new DetailPlanificationCollection($planifications))
            ->additional([
                'msg' => [
                    'summary' => 'Consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    //filtrar cursos por carrera
    public function getCoursesByCareer(GetCoursesByCareerRequest $request, Career $career)
    {
        $sorts = explode(',', $request->sort);
        $course = Course::where('career.id', $career->id);

        $course = Course::customOrderBy($sorts)
            ->academicPeriod(($request->input('academicPeriod.id')))
            ->state(($request->input('state.id')))
            ->paginate($request->input('per_page'));

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => '',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //crear curso no existente
    public function storeCourseNew(StoreCourseNewRequest $request, Course $course)
    {
        $course = new Course();
        $course->name = $request->input('search');
        $course->participant_type = $request->input('search');
        $course->state = $request->input('estado del curso');
        $course->duration = $request->input('search');
        // $courses->started_at()->associate(Planification::find($request->input('fecha inicio de planificacion')));
        // $courses->ended_at()->associate(Planification::find($request->input('fecha fin de planificacion')));
        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Curso creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //Adjuntar el acta de aprobación
    public function uploadCertificateOfApproval(UploadCertificateOfApprovalRequest $request, File $file)
    {
        return $file->uploadFile($request);
    }

    // Files
    public function showFileCourse(Course $courses, File $file)
    {
        return $courses->showFile($file);
    }

    public function showImageCourse(Course $courses, Image $image)
    {
        return $courses->showImage($image);
    }
}

<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

use App\Http\Requests\V1\Core\Images\IndexImageRequest;
use App\Http\Requests\V1\Core\Images\UploadImageRequest;
use App\Http\Requests\V1\Cecy\Courses\ApproveCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\DeclineCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\CareerCoordinator\DestroyCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\CareerCoordinator\DestroysCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\CoordinatorCecy\GetCoursesByCoordinatorCecyRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByCategoryRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByNameRequest;
use App\Http\Requests\V1\Cecy\Courses\getCoursesByResponsibleRequest;
use App\Http\Requests\V1\Cecy\Courses\IndexCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByCareerRequest;
use App\Http\Requests\V1\Cecy\Courses\UpdateCourseGeneralDataRequest;
use App\Http\Requests\V1\Cecy\Courses\UpdateCurricularDesign;
use App\Http\Requests\V1\Cecy\Courses\UpdateStateCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\UploadCertificateOfApprovalRequest;
use App\Http\Requests\V1\Cecy\Courses\CareerCoordinator\StoreCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\CareerCoordinator\UpdateCourseNameAndDurationRequest;
use App\Http\Requests\V1\Cecy\Courses\CatalogueCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\UpdateCourseRequest;
use App\Http\Requests\V1\Cecy\DetailPlanifications\AssignInstructorsRequest;
use App\Http\Requests\V1\Cecy\Planifications\GetDateByshowYearScheduleRequest;
use App\Http\Requests\V1\Cecy\Planifications\GetPlanificationByResponsableCourseRequest;
use App\Http\Requests\V1\Cecy\Planifications\IndexPlanificationRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetPlanificationsByCourseRequest;
use App\Http\Requests\V1\Core\Files\DestroysFileRequest;
use App\Http\Requests\V1\Core\Files\IndexFileRequest;
use App\Http\Requests\V1\Core\Files\UpdateFileRequest;
use App\Http\Requests\V1\Core\Files\UploadFileRequest;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationCollection;
use App\Http\Resources\V1\Cecy\Planifications\InformCourseNeedsResource;
use App\Http\Resources\V1\Cecy\Courses\CoursesByResponsibleCollection;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationCollection;
use App\Http\Resources\V1\Cecy\Certificates\CertificateResource;
use App\Http\Resources\V1\Cecy\CourseProfiles\CourseProfileResource;
use App\Http\Resources\V1\Cecy\Courses\CoordinatorCecy\CourseByCoordinatorCecyCollection;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Planifications\ResponsibleCoursePlanifications\PlanificationByCourseCollection;
use App\Http\Resources\V1\Core\ImageResource;
use App\Models\Core\File;
use App\Models\Core\Career;
use App\Models\Core\State;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Planification;
use App\Models\Cecy\SchoolPeriod;
use App\Models\Authentication\User;
use App\Models\Core\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

//use App\Models\Cecy\Requirement;

class CourseController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:admin');
        // // $this->middleware('role:responsible_course');
        // $this->middleware('permission:view-courses')->only(['index', 'show']);
        // $this->middleware('permission:store-courses')->only(['store']);
        // $this->middleware('permission:update-courses')->only(['update']);
        // $this->middleware('permission:delete-courses')->only(['destroy', 'destroys']);
    }

    public function index(IndexCourseRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $courses = Course::customOrderBy($sorts)
            ->name($request->input('search'))
            ->code($request->input('search'))
            ->schoolPeriodId($request->input('schoolPeriod.id'))
            ->paginate($request->input('per_page'));

        return (new CourseCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function catalogue(CatalogueCourseRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $courses = Course::customOrderBy($sorts)
            ->abbreviation($request->input('search'))
            ->alignment($request->input('search'))
            ->code($request->input('search'))
            ->name($request->input('search'))
            ->record_number($request->input('search'))
            ->local_proposal($request->input('search'))
            ->objective($request->input('search'))
            ->project($request->input('search'))
            ->setec_name($request->input('search'))
            ->summary($request->input('search'))
            ->limit(1000)
            ->get();

        return (new CourseCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    // Función privada que permite obtener cursos aprobados
    private function getApprovedPlanifications()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $planificationApproved = Catalogue::where('type', $catalogue['planification_state']['type'])
            ->where('code', $catalogue['planification_state']['approved'])->first();
        return $planificationApproved;
    }

    // Obtiene los cursos públicos aprobados (Done)
    public function getPublicCourses(IndexCourseRequest $request)
    {
        $planificationApproved = $this->getApprovedPlanifications();
        $planifications = $planificationApproved->planifications()
            ->whereHas('course', function ($course) use ($request) {
                $course
                    ->name($request->input('search'))
                    ->where('public', true);
            })->paginate($request->input('per_page'));

        return (new PlanificationCollection($planifications))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // Obtiene los cursos públicos aprobados por categoria (Done)
    public function getPublicCoursesByCategory(IndexCourseRequest $request, Catalogue $category)
    {
        $planificationApproved = $this->getApprovedPlanifications();
        $planifications = $planificationApproved->planifications()
            ->whereHas('course', function ($course) use ($category) {
                $course
                    ->category($category)
                    ->where('public', true);
            })
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

    // Obtiene los cursos privados aprobados por tipo de participante (Done)
    public function getPrivateCoursesByParticipantType(IndexPlanificationRequest $request)
    {
        $participant = Participant::where('user_id', $request->user()->id)->first();

        $catalogue = Catalogue::find($participant->type_id);

        $courses = $catalogue->courses()->get();

        $coursesId = [];

        foreach ($courses as $course) {
            array_push($coursesId, $course->id);
        }

        $planificationApproved = $this->getApprovedPlanifications();
        $planifications = $planificationApproved->planifications()
            ->whereHas('course', function ($course) use ($request, $coursesId) {
                $course
                    ->name($request->input('search'))
                    ->where('public', true)
                    ->orwhereIn('id', $coursesId);
            })
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

    // Obtiene los cursos privados aprobados por tipo de participante y filtrados por categoria (Done)
    public function getPrivateCoursesByParticipantTypeAndCategory(getCoursesByCategoryRequest $request, Catalogue $category)
    {
        $sorts = explode(',', $request->input('sort'));

        $participant = Participant::where('user_id', $request->user()->id)->first();

        $catalogue = Catalogue::find($participant->type_id);

        $courses = $catalogue->courses()->get();

        $coursesId = [];

        foreach ($courses as $course) {
            array_push($coursesId, $course->id);
        }

        $planificationApproved = $this->getApprovedPlanifications();
        $planifications = $planificationApproved->planifications()
            ->whereHas('course', function ($course) use ($coursesId, $category) {
                $course
                    ->orwhereIn('id', $coursesId)
                    ->category($category)
                    ->where('public', true);
            })
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

    // Actualiza la informacion del diseño curricular (Done)
    public function updateCurricularDesignCourse(UpdateCurricularDesign $request, Course $course)
    {
        $course->area()->associate(Catalogue::find($request->input('area.id')));
        $course->speciality()->associate(Catalogue::find($request->input('speciality.id')));
        $course->alignment = $request->input('alignment');
        $course->objective = $request->input('objective');
        $course->techniques_requisites = $request->input('techniquesRequisites');
        $course->teaching_strategies = $request->input('teachingStrategies');
        $course->evaluation_mechanisms = $request->input('evaluationMechanisms');
        $course->learning_environments = $request->input('learningEnvironments');
        $course->practice_hours = $request->input('practiceHours');
        $course->theory_hours = $request->input('theoryHours');
        $course->bibliographies = $request->input('bibliographies');
        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Información del diseño curricular, actualizada',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    //visualizar todos los cursos (Done)
    public function getCourses()
    {
        return (new CourseCollection(Course::paginate(100)))
            ->additional([
                'msg' => [
                    'summary' => 'Me trae los cursos',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    //obtener los cursos asignados a un docente responsable logueado (Done)
    public function getCoursesByResponsibleCourse(getCoursesByResponsibleRequest $request)
    {
        $instructor = Instructor::firstWhere('user_id', $request->user()->id);
        if (!isset($instructor)) {
            return response()->json([
                'msg' => [
                    'summary' => 'El usuario no es un instructor',
                    'detail' => '',
                    'code' => '404'
                ],
                'data' => null
            ], 404);
        }

        $courses = Course::where('responsible_id', $instructor->id)
            ->orWhereHas('planifications', function ($query) use ($instructor) {
                $query->where('responsible_course_id', $instructor->id);
            })
            ->get();

        return (new CoursesByResponsibleCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'Consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    //Trae toda la info de un curso seleccionado (?)
    public function show(Course $course)
    {
        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    //actualiza datos generales de un curso seleccionado  (Done)
    public function updateGeneralInformationCourse(UpdateCourseGeneralDataRequest $request, Course $course)
    {
        // return "updateGeneralInformationCourse";
        $course->career()->associate(Career::find($request->input("career.id")));
        $course->category()->associate(Catalogue::find($request->input('category.id'))); //categoria de curso, arte, tecnico, patrimocio,etc.
        $course->certifiedType()->associate(Catalogue::find($request->input('certifiedType.id'))); //tipo de certificado asistencia, aprobacion
        $course->courseType()->associate(Catalogue::find($request->input('courseType.id'))); //tipo de curso tecnico, administrativo
        $course->entityCertification()->associate(Catalogue::find($request->input("entityCertification.id"))); //entidad que valida SENESCYT SETEC< CECY
        $course->formationType()->associate(Catalogue::find($request->input('formationType.id'))); //tecinoc administrativo, ponencia ????
        $course->modality()->associate(Catalogue::find($request->input('modality.id'))); //modalidad presencial, virtual
        $course->catalogues()->sync($request->input('participantTypes.ids'));

        //campos propios
        $course->abbreviation = $request->input('abbreviation');
        $course->duration = $request->input('duration');
        $course->needs = $request->input('needs');
        $course->project = $request->input('project');
        $course->summary = $request->input('summary');
        $course->target_groups = $request->input("targetGroups"); //poblacion a la que va dirigda
        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Información general del curso actualizada',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    //Obtener cursos y Filtrarlos por peridos lectivos , carrera o estado (Done)
    //el que hizo esto debe cambiar lo que se envia por json a algo que se envia por params
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
                    'summary' => 'Consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    //Mostrar los KPI de cursos aprobados, por aprobar y en proceso (Done)
    public function getCoursesKPI(Request $request)
    {
        return "getCoursesKPI";

        $courses = DB::table('courses as cr')
            ->join('catalogue as ct', 'ct.id', '=', 'cr.state_id')
            ->where('ct.name', '=', 'APPROVED, TO_BE_APPROVED, IN_PROCESS')
            ->select(DB::raw('count(*) as course_count'))
            ->first()
            ->paginate($request->input('per_page'));


        echo $courses->course_count;
    }

    //Asignar código al curso (Done)
    public function assignCodeToCourse(Request $request, Course $course)
    {
        return "assignCodeToCourse";
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

    // descarga las necesidades de un curso (Done)
    public function informCourseNeeds(Course $course)
    {
        //trae un informe de nececidades de una planificacion, un curso en especifico por el docente que se logea

        $planification = $course->planifications()->with('vicerector')->first();
        $days = $planification->detailPlanifications()->with('day')->get();
        $classrooms = $planification->detailPlanifications()->with('classroom')->get();
        $instructor = Instructor::where('id', $planification->responsible_course_id)->first();
        //$user =  $instructor->user();
        $responsibleOcs = Authority::firstWhere('id', $planification->responsible_ocs_id);
        $user = User::firstWhere('id', $instructor->user_id);
        //return $responsibleOcs;
        $pdf = PDF::loadView('reports/report-needs', [
            'planification' => $planification,
            'course' => $course,
            'days' => $days,
            'classrooms' => $classrooms,
            'user' => $user,
            'responsibleOcs' => $responsibleOcs
        ]);

        return $pdf->stream('informNeeds.pdf');
    }

    //Traer todos los cursos planificados de un año en especifico (Done)
    // el que hizo esto debe enviar el año en especifico bien por el url
    // o por params
    public function showYearSchedule(GetDateByshowYearScheduleRequest $request)
    {
        // $year = $planificacion->whereYear('started_at')->first();
        //$planifications = Planification::whereYear('started_at', '=', 2022)->with(['course', 'detailPlanifications'])->get();

        $planifications = Planification::whereYear('started_at', '=', $request->input("startedAt"))->with(['course', 'responsibleCourse.user', 'detailPlanifications'])->get();
        //$detailPlanifications = $planifications->detailPlanifications()->get();
        //$detailPlanifications=$planifications->detailPlanifications()->with('classroom')->get();

        //$detailPlanifications = $planification->detailPlanifications()->get();
        $detailPlanifications = Planification::whereYear('started_at', '=', $request->input("startedAt"))->with(['detailPlanifications'])->get();
        //$responsibleCourse = Planification::whereYear('started_at', '=', $request->input("startedAt"))->with('responsibleCourse.user')->get(); 
        /*     $course = $planifications->course()->get();
        $detailPlanifications=$planifications->detailPlanifications()->get(); */
        $data = [
            'planifications' => $planifications,
            'detailPlanifications' => $detailPlanifications,
            // 'responsibleCourse' => $responsibleCourse

        ];
        //return $data ;

        $pdf = PDF::loadView('reports/report-year-schedule', [
            'planifications' => $planifications,
            'detailPlanifications' => $detailPlanifications,
            //'responsibleCourse' => $responsibleCourse
        ]);
        $pdf->setOptions([
            'orientation' => 'landscape',
            'page-size' => 'a4'
        ]);
        return $pdf->stream('informNeeds.pdf');
    }




    //Traer cursos de un docente instructor (Deberia estar en planificacion dice cursos pero trae planificaciones)(Done)
    public function getCoursesByInstructor(GetPlanificationByResponsableCourseRequest $request)
    {
        //return "getCoursesByInstructor";
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

    //traer participante de un curso
    public function certificateParticipants(Course $course)
    {

        $planification = $course->planifications()->get();

        $data = new CertificateResource($planification);
        $pdf = PDF::loadView('certificate-student', ['registrations' => $data]);
        $pdf->setOptions([
            'orientation' => 'landscape',

            'page-size' => 'a4'
        ]);
        return $pdf->stream('certificate.pdf');
    }

    public function updateStateCourse(UpdateStateCourseRequest $request, Course $course)
    {
        $course->state_id = $request->id;
        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Estado actualizado',
                    'detail' => 'El estado del curso pudo haber cambiado de posición',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    // Adjuntar el acta de aprobación
    public function uploadCertificateOfApproval(UploadCertificateOfApprovalRequest $request, File $file)
    {
        return $file->uploadFile($request);
    }

    public function getCoursesByCareer(GetCoursesByCareerRequest $request, Career $career)
    {
        $sorts = explode(',', $request->input('sort'));

        $courses = $career->courses()
            ->customOrderBy($sorts)
            ->code($request->input('search'))
            ->name($request->input('search'))
            ->state($request->input('search'))
            ->responsible($request->input('search'))
            ->paginate($request->input('perPage'));

        return (new CourseCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    /**
     * storeNewCourse
     */
    public function storeCourseByCareer(StoreCourseRequest $request, Career $career)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        $currentState = Catalogue::where('type', $catalogue['school_period_state']['type'])
            ->where('code', $catalogue['school_period_state']['current'])
            ->first();
        $toBeApprovedState = Catalogue::where('type', $catalogue['planification_state']['type'])
            ->where('code', $catalogue['planification_state']['to_be_approved'])
            ->first();
        $currentSchoolPeriod = SchoolPeriod::where('state_id', $currentState->id)
            ->first();
        $responsible = Instructor::find($request->input('responsible.id'));

        if ($request->input('duration') < Course::MINIMUM_HOURS) {
            return response()->json([
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'La duración no debe ser menor a 40 horas',
                    'code' => '404'
                ],
                'data' => null
            ], 404);
        }

        $course = new Course();

        $course->career()->associate($career);
        $course->responsible()->associate($responsible);
        $course->schoolPeriod()->associate($currentSchoolPeriod);
        $course->state()->associate($toBeApprovedState);

        $course->duration = $request->input('duration');
        $course->name = $request->input('name');
        $course->proposed_at = now();

        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Curso creado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])->response()->setStatusCode(201);
    }

    /**
     * updateInitialCourse
     */
    public function updateInitialCourse(UpdateCourseNameAndDurationRequest $request, Course $course)
    {
        // DDRC-C: actualiza los campos duracion nombre resonsables
        if ($request->input('duration') < Course::MINIMUM_HOURS) {
            return response()->json([
                'msg' => [
                    'summary' => 'Error',
                    'detail' => 'La duración no debe ser menor a 40 horas',
                    'code' => '404'
                ],
                'data' => null
            ], 404);
        }

        $responsible = Instructor::find($request->input('responsible.id'));

        $course->responsible()->associate($responsible);

        $course->duration = $request->input('duration');
        $course->name = $request->input('name');

        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Curso Actualizado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    /**
     * destroyCourse
     */
    public function destroyCourse(DestroyCourseRequest $request, Course $course)
    {
        // DDRC-C: Elimina un curso
        $course->delete();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Curso Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function destroys(DestroysCourseRequest $request)
    {
        // DDRC-C: elimina cursos
        $courses = Course::whereIn('id', $request->input('ids'))->get();
        Course::destroy($request->input('ids'));

        return (new CourseCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'Cursos eliminados',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    /*
        * approveCourse
    */
    public function approveCourse(ApproveCourseRequest $request, Course $course)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $state = Catalogue::where('type', $catalogue['course_state']['type'])
            ->where('code', $catalogue['course_state']['approved'])->first();

        $course->state()->associate($state);
        $course->code = $request->input('code');
        $course->approved_at = $request->input('approvedAt');
        $course->expired_at = $request->input('expiredAt');
        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Curso Aprobado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    /*
        * declineCourse
    */
    public function declineCourse(DeclineCourseRequest $request, Course $course)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $state = Catalogue::where('type', $catalogue['course_state']['type'])
            ->where('code', $catalogue['course_state']['not_approved'])->first();

        $course->state()->associate($state);
        $course->save();

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Curso Rechazado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function getPlanifications(GetPlanificationsByCourseRequest $request, Course $course)
    {
        $sorts = explode(',', $request->input('sort'));

        $planifications = $course->planifications()
            ->customOrderBy($sorts)
            ->code($request->input('search'))
            ->state($request->input('search'))
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

    function getPlanificationsByRol(Request $request, Course $course)
    {
        $sorts = explode(',', $request->input('sort'));

        $planifications = $course->planifications()
            ->where($request->input('role.name'), $request->input('role.id'))
            ->customOrderBy($sorts)
            ->code($request->input('search'))
            ->state($request->input('search'))
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

    /**
     * Assign instructors to profile.
     */
    public function assignInstructors(AssignInstructorsRequest $request, Course $course)
    {
        $courseProfile = $course->courseProfile;
        $courseProfile->instructors()->sync($request->input('ids'));

        return (new CourseResource($course))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => 'Asignación actualizada',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }


    // Files
    public function indexFiles(IndexFileRequest $request, Course $course)
    {
        return $course->indexFiles($request);
    }

    public function uploadFile(UploadFileRequest $request, Course $course)
    {
        return $course->uploadFile($request);
    }

    public function downloadFile(Course $course, File $file)
    {
        return $course->downloadFile($file);
    }

    public function showFileCourse(Course $course, File $file)
    {
        return $course->showFile($file);
    }

    public function updateFile(UpdateFileRequest $request, Course $course, File $file)
    {
        return $course->updateFile($request, $file);
    }

    public function destroyFile(Course $course, File $file)
    {
        return $course->destroyFile($file);
    }

    public function destroyFiles(Course $course, DestroysFileRequest $request)
    {
        return $course->destroyFiles($request);
    }

    //Images
    public function uploadImage(UploadImageRequest $request, Course $course)
    {
        $images = $course->images()->get();
        foreach ($images as $image) {
            // Storage::deleteDirectory($image->directory);
            Storage::disk('public')->deleteDirectory('images/' . $image->id);
            $image->delete();
        }

        foreach ($request->file('images') as $image) {
            $newImage = new Image();
            $newImage->name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $newImage->description = $request->input('description');
            $newImage->extension = 'jpg';
            $newImage->imageable()->associate($course);
            $newImage->save();


            Storage::disk('public')->makeDirectory('images/' . $newImage->id);

            $storagePath = storage_path('app/public/images/');
            $course->uploadOriginal(InterventionImage::make($image), $newImage->id, $storagePath);
            $course->uploadLargeImage(InterventionImage::make($image), $newImage->id, $storagePath);
            $course->uploadMediumImage(InterventionImage::make($image), $newImage->id, $storagePath);
            $course->uploadSmallImage(InterventionImage::make($image), $newImage->id, $storagePath);

            $newImage->directory = 'images/' . $newImage->id;
            $newImage->save();
        }
        return (new ImageResource($newImage))->additional(
            [
                'msg' => [
                    'summary' => 'Imagen cargada exitosamente!',
                    'detail' => '',
                    'code' => '200'
                ]
            ]
        );
    }

    public function indexPublicImages(IndexImageRequest $request, Course $course)
    {
        return $course->indexPublicImages($request);
    }
}

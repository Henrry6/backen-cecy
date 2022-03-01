<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Courses\CoordinatorCecy\GetCoursesByCoordinatorCecyRequest as CoordinatorCecyGetCoursesByCoordinatorCecyRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByCategoryRequest;
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
use App\Http\Requests\V1\Cecy\Courses\UpdateCurricularDesign;
use App\Http\Requests\V1\Cecy\Courses\UploadCertificateOfApprovalRequest;
use App\Http\Requests\V1\Cecy\Planifications\GetDateByshowYearScheduleRequest;
use App\Http\Requests\V1\Cecy\Planifications\GetPlanificationsByResponsibleCecyRequest;
use App\Http\Requests\V1\Cecy\Planifications\IndexPlanificationRequest;
use App\Http\Requests\V1\Core\Images\UploadImageRequest;
use App\Http\Resources\V1\Cecy\Courses\CourseByCoordinatorCecyCollection;
use App\Http\Resources\V1\Cecy\Courses\CoursePublicPrivateCollection;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationInformNeedResource;
use App\Http\Resources\V1\Cecy\Planifications\InformCourseNeedsResource;
use App\Http\Resources\V1\Cecy\Courses\CoursesByResponsibleCollection;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationCollection;
use App\Http\Resources\V1\Cecy\Certificates\CertificateResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationsResponsibleCecyCollection;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Planification;
use App\Models\Core\File;
use App\Models\Core\Image;
use App\Models\Core\State;
use App\Models\Core\Career;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
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
    private function getApprovedPlanifications()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $planificationApproved = Catalogue::where('type',  $catalogue['planification_state']['type'])
            ->where('code', $catalogue['planification_state']['approved'])->first();
        return $planificationApproved;
    }

    private function getApprovedCourses()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $courseApproved = Catalogue::where('type',  $catalogue['course_state']['type'])
            ->where('code', $catalogue['course_state']['approved'])->first();
        return $courseApproved;
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

    // Obtiene los cursos públicos aprobados por nombre (Done)
    public function getPublicCoursesByName(IndexCourseRequest $request)
    {

        $planificationApproved = $this->getApprovedPlanifications();
        $planifications = $planificationApproved->planifications()
            ->whereHas('course', function ($course) use ($request) {
                $course
                    ->name($request->input('search'))
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
        $sorts = explode(',', $request->input('sort'));

        $courseApproved = $this->getApprovedCoursesId();


        $participant = Participant::where('user_id', $request->user()->id)->first();

        $catalogue = Catalogue::find($participant->type_id);

        $courses = $catalogue->courses()->paginate($request->input('per_page'));

        return (new CoursePublicPrivateCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // Obtiene los cursos privados aprobados por tipo de participante y filtrados por categoria (Done)
    public function getPrivateCoursesByCategory(getCoursesByCategoryRequest $request, Catalogue $category)
    {

        $participant = Participant::where('user_id', $request->user()->id)->first();

        $catalogue = Catalogue::find($participant->type_id);

        $courses = $catalogue->courses()->paginate();

        return (new CoursePublicPrivateCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // Obtiene los cursos privados aprobados por tipo de participante y filtrados por nombre (Done)
    public function getPrivateCoursesByName(getCoursesByNameRequest $request)
    {

        $participant = Participant::where('user_id', $request->user()->id)->first();

        $catalogue = Catalogue::find($participant->type_id);

        $courses = $catalogue->courses()->paginate();

        return (new CoursePublicPrivateCollection($courses))
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
        return "updateCurricularDesignCourse";
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
            ]);
    }

    //obtener los cursos asignados a un docente responsable logueado (Done)
    public function getCoursesByResponsibleCourse(getCoursesByResponsibleRequest $request)
    {
        // return 'xd';

        $instructor = Instructor::FirstWhere('user_id', $request->user()->id);
        $courses = Course::where('responsible_id', $instructor->id)->get();


        return (new CoursesByResponsibleCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'Consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
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
            ]);
    }

    //actualiza datos generales de un curso seleccionado  (Done)
    public function updateGeneralInformationCourse(UpdateCourseGeneralDataRequest $request, Course $course)
    {
        return "updateGeneralInformationCourse";
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

    //Obtener cursos y Filtrarlos por peridos lectivos , carrera o estado (Done)
    //el que hizo esto debe cambiar lo que se envia por json a algo que se envia por params
    public function getCoursesByCoordinator(CoordinatorCecyGetCoursesByCoordinatorCecyRequest $request)
    {

        return "getCoursesByCoordinator";
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

    // Ingresar el motivo del por cual el curso no esta aprobado (Done)
    public function notApproveCourseReason(Request $request, Course $course)
    {
        return "notApproveCourseReason";
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

    // Mostrar las necesidades de un curso (Done)
    public function informCourseNeeds(Course $course)
    {
        //trae un informe de nececidades de una planificacion, un curso en especifico por el docente que se logea

        $planification = $course->planifications()->get();

        $data =  new InformCourseNeedsResource($planification);
        $pdf = PDF::loadView('reports/report-needs', ['planifications' => $data]);

        return $pdf->stream('informNeeds.pdf');
    }

    //Traer todos los cursos planificados de un año en especifico (Done)
    // el que hizo esto debe enviar el año en especifico bien por el url 
    // o por params
    public function showYearSchedule(GetDateByshowYearScheduleRequest $request)
    {
        return "showYearSchedule";
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

    //Traer la informacion de diseño curricular (Done)
    public function showCurricularDesign(getCoursesByNameRequest $request, Course $course)
    {
        return "showCurricularDesign";
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

    // Traer la informacion del informe final del curso (Done)
    public function showCourseFinalReport(getCoursesByNameRequest $request, Course $course)
    {
        return "showCourseFinalReport";
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

    //Traer cursos de un docente instructor (Deberia estar en planificacion dice cursos pero trae planificaciones)(Done)
    public function getCoursesByInstructor(GetPlanificationByResponsableCourseRequest $request)
    {
        return "getCoursesByInstructor";
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

    // Filtrar cursos por carrera (Done)
    public function getCoursesByCareer(GetCoursesByCareerRequest $request, Career $career)
    {
        return "getCoursesByCareer";
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

    // Crear curso nuevo completamente (Done)
    public function storeNewCourse(StoreCourseNewRequest $request)
    {
        return "storeNewCourse";
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

     //obtener los cursos asignados a un Responsable logueado (Done)
     public function getResponsibleCecyByCourses(GetPlanificationsByResponsibleCecyRequest $request)
     {
        
         $authority = Authority::FirstWhere('user_id', $request->user()->id);
        //  $planification = $authority->planifications()->get();
         $planification = Planification::where('responsible_cecy_id', $authority->id)->get();
 

         return (new PlanificationsResponsibleCecyCollection($planification))
             ->additional([
                 'msg' => [
                     'summary' => 'Consulta exitosa',
                     'detail' => '',
                     'code' => '200'
                 ]
             ]);
     }

    // Adjuntar el acta de aprobación
    public function uploadCertificateOfApproval(UploadCertificateOfApprovalRequest $request, File $file)
    {
        return $file->uploadFile($request);
    }

    // Files
    public function showFileCourse(Course $course, File $file)
    {
        return $course->showFile($file);
    }
    //Images
    public function showImageCourse(Course $course, Image $image)
    {
        return $course->showImage($image);
    }

    public function uploadImageCourse(UploadImageRequest $request, Course $course)
    {
        return $course->uploadImage($request);
    }
}

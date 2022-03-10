<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Courses\CoordinatorCecy\GetCoursesByCoordinatorCecyRequest;
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
use App\Http\Requests\V1\Cecy\Courses\UpdateStateCourseRequest;
use App\Http\Requests\V1\Cecy\Courses\UploadCertificateOfApprovalRequest;
use App\Http\Requests\V1\Cecy\Planifications\GetDateByshowYearScheduleRequest;
use App\Http\Requests\V1\Cecy\Planifications\IndexPlanificationRequest;
use App\Http\Requests\V1\Core\Images\IndexImageRequest;
use App\Http\Requests\V1\Core\Images\UploadImageRequest;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationInformNeedResource;
use App\Http\Resources\V1\Cecy\Planifications\InformCourseNeedsResource;
use App\Http\Resources\V1\Cecy\Courses\CoursesByResponsibleCollection;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationCollection;
use App\Http\Resources\V1\Cecy\Certificates\CertificateResource;
use App\Http\Resources\V1\Cecy\Courses\CoordinatorCecy\CourseByCoordinatorCecyCollection;
use App\Http\Resources\V1\Cecy\Planifications\CoordinatorCecy\PlanificationResource;

use App\Http\Resources\V1\Cecy\Planifications\InformCourseNeedsCollection;
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
    }

    // Función privada que permite obtener cursos aprobados
    private function getApprovedPlanifications()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $planificationApproved = Catalogue::where('type',  $catalogue['planification_state']['type'])
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
        // return "updateCurricularDesignCourse";
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

        $instructor = Instructor::FirstWhere('user_id', $request->user()->id);
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
        $course->target_groups = $request->input("targetGroups"); //poblacion a la que va dirigda
        $course->project = $request->input('project');
        $course->summary = $request->input('summary');
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
    /*     public function informCourseNeeds(Course $course)
    {
        //trae un informe de nececidades de una planificacion, un curso en especifico por el docente que se logea

        $planification = $course->planifications()->first();

     $data= new InformCourseNeedsResource($planification);
        $pdf = PDF::loadView('reports/report-needs', ['planification' => $data]);

        return $pdf->stream('informNeeds.pdf'); 
    } */

    // Mostrar las necesidades de un curso (Done)
    public function informCourseNeeds(Course $course)
    {
        //trae un informe de nececidades de una planificacion, un curso en especifico por el docente que se logea

        $planification = $course->planifications()->with('responsibleCourse.user')->first();

        $days = $planification->detailPlanifications()->with('day')->get();

        $classrooms = $planification->detailPlanifications()->with('classroom')->get();

        //return $planification;

        $pdf = PDF::loadView('reports/report-needs', [
            'planification' => $planification,
            'course' => $course,
            'days' => $days,
            'classrooms' => $classrooms,
        ]);

        return $pdf->stream('informNeeds.pdf');
    }

    //Traer todos los cursos planificados de un año en especifico (Done)
    // el que hizo esto debe enviar el año en especifico bien por el url 
    // o por params
    public function showYearSchedule(Planification $planification)
    {
                // $year = $planificacion->whereYear('started_at')->first();
        $planifications = $planification->whereYear('started_at','=',2022)->get();
  /*       $course = $planifications->course()->get();
        $detailPlanifications=$planifications->detailPlanifications()->get(); */
        

    //   return $detailPlanifications ;

        $pdf = PDF::loadView('reports/report-year-schedule',[
            'planifications'=>$planifications
        ]);
        $pdf->setOptions([
            'orientation' => 'landscape',
            'page-size' => 'a4'
        ]);
        return $pdf->stream('informNeeds.pdf');
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

    public function updateStateCourse(UpdateStateCourseRequest $request, Course $course)
    {
        $course->state_id = $request -> id;
        $course ->save();

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

    // Files
    public function showFileCourse(Course $course, File $file)
    {
        return $course->showFile($file);
    }


    //Images

  
    public function uploadPublicImage(UploadImageRequest $request, Course $course)
    {
        return $course->uploadPublicImage($request);
    }

    public function indexPublicImages(IndexImageRequest $request,Course $course)
    {
        return $course->indexPublicImages($request);
    }

}

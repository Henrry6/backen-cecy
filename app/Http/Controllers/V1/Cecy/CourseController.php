<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByCategoryRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByNameRequest;
use App\Http\Requests\V1\Cecy\Courses\IndexCourseRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Requests\V1\Cecy\Courses\UpdateCourseRequest;
use App\Http\Requests\V1\Cecy\Planifications\IndexPlanificationRequest;
use App\Http\Resources\V1\Cecy\Courses\CoursePublicPrivateCollection;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Planification;
use App\Models\Core\File;
use App\Models\Core\Image;

class CourseController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:store-catalogues')->only(['store']);
    //     $this->middleware('permission:update-catalogues')->only(['update']);
    //     $this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    // }

    // Actualiza la informacion del diseño curricular
    // CourseController
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


    // Funcion privada para obtener cursos de planifaciones aprovadas
    private function getCoursesByAcceptedPlanification()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        $planifications = Planification::where('state', $catalogue['planification_state']['approved'])->get();
        $courses = $planifications->courses()->get();

        return $courses;
    }
    // Obtiene los cursos públicos aprobados
    public function getPublicCourses(IndexCourseRequest $request)
    {

        $courses = $this->getCoursesByAcceptedPlanification();
        $public_courses = $courses->where('public', true)->get();

        return (new CoursePublicPrivateCollection($public_courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // Obtiene los cursos públicos aprobados por categoria

    public function getPublicCoursesByCategory(GetCoursesByCategoryRequest $request)
    {
        $courses = $this->getCoursesByAcceptedPlanification();
        $sorts = explode(',', $request->sort);

        $coursesByCategory = $courses
            ->customOrderBy($sorts)
            ->category($request->input('category.id'))
            ->paginate($request->input('per_page'));

        $public_courses = $coursesByCategory->where('public', true)->get();


        return (new CoursePublicPrivateCollection($public_courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // Obtiene los cursos públicos aprobados por nombre

    public function getPublicCoursesByName(GetCoursesByNameRequest $request)
    {
        $courses = $this->getCoursesByAcceptedPlanification();
        $sorts = explode(',', $request->sort);

        $coursesByName = $courses
            ->customOrderBy($sorts)
            ->name($request->input('name'))
            ->paginate($request->input('per_page'));

        $public_courses = $coursesByName->where('public', true)->get();


        return (new CoursePublicPrivateCollection($public_courses))
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
        $catalogues = Catalogue::get();

        $participant = Participant::where('user_id', $request->user()->id)->get();
        $typeParticipant = $participant->type();

        $participants_courses = $catalogues->courses()->where('catalogue_id', $typeParticipant)->exists();

        $allowedCourses = $participants_courses->courses();


        return (new CoursePublicPrivateCollection($allowedCourses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
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

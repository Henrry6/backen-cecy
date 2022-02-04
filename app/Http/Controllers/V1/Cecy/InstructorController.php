<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Instructor\DestroysInstructorRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\Instructor;
use App\Http\Resources\V1\Cecy\Courses\CourseResource;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Core\Users\UserCollection;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;

class InstructorController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:store-catalogues')->only(['store']);
    //     $this->middleware('permission:update-catalogues')->only(['update']);
    //     $this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    // }

    // Devuelve los cursos que le fueron asignados al docente responsable
    // InstructorCotroller
    public function getCourses(Instructor $instructor)
    {
        $courses = $instructor->courses()->get();
        return (new CourseCollection($courses))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
    /*
        Obtener la información personal de cada instructor que dicta dado un curso
    */
    public function getInstructorsInformationByCourse(Course $course)
    {
        $planification = $course->planifications()->get();
        $detailPlanifications = $planification->detailPlanifications()->get();
        $instructors = $detailPlanifications->instructors()->get();
        $user_instructors = $instructors->user()->get();

        return (new UserCollection($user_instructors))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

     //Para actualizar el tipo de instructor
    public function updateTypeInstructors(Request $request, Instructor $instructor)
    {
        $instructor->type()->associate(Catalogue::find($request->input('type.id')));
        $instructor->save();

        return (new InstructorResource($instructor))
            ->additional([
                'msg' => [
                    'summary' => 'Instructor Actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);

    }

    // para eliminar un instructor

    public function destroyInstructors(DestroysInstructorRequest $request)
    {
        $instructor = Instructor::whereIn('id', $request->input('ids'))->get();
        Instructor::destroy($request->input('ids'));
        return (new InstructorResource($instructor))
            ->additional([
                'msg' => [
                    'summary' => 'Instructor Eliminado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);

    }
}

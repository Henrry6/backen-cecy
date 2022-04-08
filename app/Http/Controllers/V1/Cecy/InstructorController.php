<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Http\Requests\V1\Cecy\Courses\getCoursesByResponsibleRequest;
use App\Http\Requests\V1\Cecy\Instructors\IndexInstructorRequest;
use App\Http\Requests\V1\Cecy\Instructors\StoreInstructorRequest;
use App\Http\Requests\V1\Cecy\Instructors\StoreInstructorsRequest;
use App\Http\Requests\V1\Cecy\Instructors\CatalogueInstructorRequest;
// use App\Http\Requests\V1\Cecy\Instructor\DestroysInstructorRequest;
// use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationByInstructorCollection;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Instructors\InstructorCollection;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Core\Users\UserCollection;
use App\Models\Cecy\Catalogue;
// use App\Models\Cecy\Course;
use App\Models\Cecy\Instructor;
use App\Models\Authentication\User;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailPlanification;

class InstructorController extends Controller
{

    public function catalogue(CatalogueInstructorRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $instructors =  Instructor::customOrderBy($sorts)
            ->limit(1000)
            ->get();

        return (new InstructorCollection($instructors))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function __construct()
    {
        //$this->middleware('permission:store-catalogues')->only(['store']);
        //$this->middleware('permission:update-catalogues')->only(['update']);
        //$this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    }

    public function index(IndexInstructorRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $instructors = Instructor::customOrderBy($sorts)
            ->paginate($request->input('per_page'));

        return (new InstructorCollection($instructors))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function storeInstructor(StoreInstructorRequest $request, Instructor $instructor)
    {

        $instructor = new Instructor();

        $instructor->state()
            ->associate(Catalogue::find($request->input('state.id')));
        $instructor->type()
            ->associate(Catalogue::find($request->input('type.id')));
        $instructor->user()
            ->associate(User::find($request->input('user.id')));

        $instructor->save();

        return (new InstructorResource($instructor))
            ->additional([
                'msg' => [
                    'summary' => 'Instructor creado',
                    'Institution' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function storeInstructors(StoreInstructorsRequest $request, Instructor $instructor)
    {
        $instructors = collect();

        foreach ($request->input('ids') as $userId) {

            $instructor = new Instructor();

            $instructor->user()
                ->associate(User::find($request->input($userId)));

            $instructor->save();

            $instructors->push($instructor);
        }

        return (new InstructorCollection($instructors))
            ->additional([
                'msg' => [
                    'summary' => 'Instructores creados',
                    'Institution' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function updateStateInstructor(Request $request, Instructor $instructor)
    {
        $instructor->state()->associate(Catalogue::find($request->input('state.id')));
        $instructor->save();

        return (new InstructorResource($instructor))
            ->additional([
                'msg' => [
                    'summary' => 'Instructor actualizado',
                    'detail' => 'El estado del instructor a se cambio',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function updateTypeInstructor(Request $request, Instructor $instructor)
    {
        $instructor->type()->associate(Catalogue::find($request->input('type.id')));
        $instructor->save();

        return (new InstructorResource($instructor))
            ->additional([
                'msg' => [
                    'summary' => 'Instructor actualizado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function getAuthorizedInstructorsOfCourse(IndexInstructorRequest $request, DetailPlanification $detailPlanification) //mejor seria que vieniera el detalle de planification como parametro en lugar del curso,
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        $activeState = Catalogue::where('type', $catalogue['instructor_state']['type'])
            ->where('code', $catalogue['instructor_state']['active'])->first();

        $planification = $detailPlanification->planification()->with('course')->first();
        $course = $planification->course;

        // $instructors = Instructor::whereRelation('courseProfiles', 'state_id', $activeState->id)->get();
        $instructors = Instructor::whereHas('courseProfiles', function ($courseProfiles) use ($course, $activeState) {
            $courseProfiles->where('course_id', $course->id)
                ->where('state_id', $activeState->id);
        })->get();

        // $instructors = $course->courseProfile()->first();
        // return $instructors;
        return (new InstructorCollection($instructors))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function getAssignedInstructors(IndexInstructorRequest $request, DetailPlanification $detailPlanification)
    {
        $instructors = $detailPlanification->instructors()->get();

        return (new InstructorCollection($instructors))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
}

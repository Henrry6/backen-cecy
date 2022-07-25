<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use App\Http\Requests\V1\Cecy\Courses\getCoursesByResponsibleRequest;
use App\Http\Requests\V1\Cecy\Instructors\IndexInstructorRequest;
use App\Http\Requests\V1\Cecy\Instructors\StoreInstructorRequest;
use App\Http\Requests\V1\Cecy\Instructors\StoreInstructorsRequest;
use App\Http\Requests\V1\Cecy\Instructors\CatalogueInstructorRequest;
use App\Http\Requests\V1\Cecy\Instructor\DestroysInstructorRequest;

// use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationByInstructorCollection;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Instructors\InstructorCollection;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Core\Users\UserResource;
use App\Http\Resources\V1\Core\Users\UserCollection;
use App\Models\Cecy\Catalogue;

// use App\Models\Cecy\Course;
use App\Models\Cecy\Instructor;
use App\Models\Authentication\User;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailPlanification;
use App\Models\Core\Phone;

class InstructorController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:store-catalogues')->only(['store']);
        //$this->middleware('permission:update-catalogues')->only(['update']);
        //$this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    }

    public function catalogue(CatalogueInstructorRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $instructors = Instructor::customOrderBy($sorts)
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

    public function index(IndexInstructorRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $instructors = Instructor::customOrderBy($sorts)
            ->user($request->input('search'))
            ->paginate($request->input('perPage'));

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

    public function store(StoreInstructorRequest $request)
    {
        $user = new User();
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = $request->input('username');


        $user->save();


        $instructor = new Instructor();

        $instructor->state()->associate(Catalogue::find($request->input('state.id')));
        $instructor->type()->associate(Catalogue::find($request->input('type.id')));
        $instructor->user()->associate($user);

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

    public function storeInstructors(StoreInstructorsRequest $request)
    {
        $instructors = collect();

        foreach ($request->input('ids') as $userId) {

            $user = User::find($userId);

            $instructor = Instructor::firstWhere('user_id', $userId);

            if (!isset($instructor)) {

                $instructor = new Instructor();

                $instructor->user()
                    ->associate($user);

                $instructor->save();

                $instructors->push($instructor);
            }
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

    public function updateStateType(Request $request, Instructor $instructor)
    {
        $instructor->state()->associate(Catalogue::find($request->input('state.id')));
        $instructor->type()->associate(Catalogue::find($request->input('type.id')));
        $instructor->save();

        return (new InstructorResource($instructor))
            ->additional([
                'msg' => [
                    'summary' => 'Instructor actualizado',
                    'detail' => 'Los datos del instructor se cambiaron',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    

    public function destroy(Instructor $instructor)
    {
        $instructor->delete();

        return (new InstructorResource($instructor))
            ->additional([
                'msg' => [
                    'summary' => 'Instructor Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function destroys(DestroysInstructorRequest $request)
    {
        $instructor = Instructor::whereIn('id', $request->input('ids'))->get();
        Instructor::destroy($request->input('ids'));
        return (new InstructorResource($instructor))
            ->additional([
                'msg' => [
                    'summary' => 'Instructor Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }


    public function getInstructorsByCourseProfile(Course $course)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        $activeState = Catalogue::where('type', $catalogue['instructor_state']['type'])
            ->where('code', $catalogue['instructor_state']['active'])->first();

        $instructors = Instructor::with(['courseProfiles' => function ($courseProfiles) use ($course) {
            $courseProfiles->where('course_id', $course->id);
        }])->where('state_id', $activeState->id)
            ->get();

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

    public function getAssignedInstructorsByDetailPlanification(IndexInstructorRequest $request, DetailPlanification $detailPlanification)
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
   
    public function getAssignedInstructorsByCourseProfile(Course $course)
    {
        $instructors = $course->load('courseProfile.instructors')->courseProfile->instructors;

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

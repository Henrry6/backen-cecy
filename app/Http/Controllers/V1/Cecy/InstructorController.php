<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Http\Requests\V1\Cecy\Courses\getCoursesByResponsibleRequest;
use App\Http\Requests\V1\Cecy\Instructors\IndexInstructorRequest;
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

class InstructorController extends Controller
{
    public function __construct()
    {
       //$this->middleware('permission:store-catalogues')->only(['store']);
       //$this->middleware('permission:update-catalogues')->only(['update']);
       //$this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    }

    public function index(IndexInstructorRequest $request)
    {
        return (new InstructorCollection(Instructor::paginate()))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'Institution' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function storeInstructor(Instructor $instructor, Request $request)
    {
        $instructor = new Instructor();

        $instructor->state()
            ->associate(Catalogue::find($request->input('state')));
        $instructor->type()
            ->associate(Catalogue::find($request->input('type')));
        $instructor->user()
            ->associate(User::find($request->input('user')));

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
    
    public function updateTypeInstructors(Request $request, Instructor $instructor)
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

}

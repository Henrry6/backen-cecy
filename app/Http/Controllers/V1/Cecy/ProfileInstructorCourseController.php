<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Models\Cecy\Course;
use App\Http\Requests\V1\Cecy\ProfileInstructorCourses\StoreProfileCourseRequest;
use App\Http\Resources\V1\Cecy\ProfileInstructorCourses\ProfileInstructorCourseResource;
use App\Models\Cecy\ProfileInstructorCourse;

class ProfileInstructorCourseController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:store')->only(['store']);
//        $this->middleware('permission:update')->only(['update']);
//        $this->middleware('permission:delete')->only(['destroy', 'destroys']);
    }

    //Agregar perfil a un curso
    
    public function storeProfileCourse(StoreProfileCourseRequest $request)
    {
        $profile = new ProfileInstructorCourse();

        $profile->course()
            ->associate(Course::find($request->input('course.id')));

        $profile->required_knowledge = $request->input('required_knowledge');

        $profile->required_experience = $request->input('required_experiences');

        $profile->required_skills = $request->input('required_skills');

        $profile->save();

        return (new ProfileInstructorCourseResource($profile))
            ->additional([
                'msg' => [
                    'summary' => 'Perfil del curso creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);

    }

}

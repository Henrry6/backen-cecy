<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\CourseProfiles\StoreProfileCourseRequest;
use App\Http\Resources\V1\Cecy\CourseProfiles\CourseProfileResource;
use App\Models\Cecy\Course;
use App\Models\Cecy\ProfileInstructorCourse;

class ProfileInstructorCourseController extends Controller
{
    public function __construct()
    {
      //$this->middleware('permission:store')->only(['store']);
      //$this->middleware('permission:update')->only(['update']);
      //$this->middleware('permission:delete')->only(['destroy', 'destroys']);
    }

    //Agregar perfil a un curso
    
    public function getCourses()
    {
        return (new ProfileCourseCollection(Course::paginate(100)))
            ->additional([
                'msg' => [
                    'summary' => 'Me trae los cursos',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    public function storeProfileCourse(StoreProfileCourseRequest $request)
    {
        $profile = new ProfileInstructorCourse();

        $profile->course()
            ->associate(Course::find($request->input('course.id')));

        $profile->required_knowledge = $request->input('required_knowledge');

        $profile->required_experience = $request->input('required_experience');

        $profile->required_skills = $request->input('required_skills');

        $profile->save();

        return (new CourseProfileResource($profile))
            ->additional([
                'msg' => [
                    'summary' => 'Perfil del curso creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);

    }

    public function updateProfileInstructorCourse(UpdateProfileInstructorCourse $request, ProfileInstructorCourse $profileInstructorCourse)
    {
        $profileInstructorCourse->required_experiences = $request->input('requiredExperiences');
        $profileInstructorCourse->required_knowledges = $request->input('requiredKnowledges');
        $profileInstructorCourse->required_skills = $request->input('requiredSkills');
        $profileInstructorCourse->save();

        return (new CourseProfileResource($profileInstructorCourse))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

}

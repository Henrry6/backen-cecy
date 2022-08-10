<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\CourseProfiles\StoreProfileCourseRequest;
use App\Http\Requests\V1\Cecy\CourseProfiles\UpdateProfileCourseRequest;
use App\Http\Requests\V1\Cecy\DetailPlanifications\AssignInstructorsRequest;
use App\Http\Resources\V1\Cecy\CourseProfiles\CourseProfileCollection;
use App\Http\Resources\V1\Cecy\CourseProfiles\CourseProfileResource;
use App\Models\Cecy\Course;
use App\Models\Cecy\CourseProfile;
use App\Models\Cecy\Planification;
use Illuminate\Support\Facades\DB;

class CourseProfileController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:store')->only(['store']);
        //$this->middleware('permission:update')->only(['update']);
        //$this->middleware('permission:delete')->only(['destroy', 'destroys']);
    }

    public function show(CourseProfile $courseProfile)
    {
        //return $courseProfile;

        //$CourseProfile = $courseProfile->courseProfile()->first();

        return (new CourseProfileResource($courseProfile))

            ->additional([
                'msg' => [
                    'summary' => 'Mostrando',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    public function index()
    {
        $CoursesProfiles = CourseProfile::get();
        return (new CourseProfileCollection($CoursesProfiles))

            ->additional([
                'msg' => [
                    'summary' => 'Mostrando todos',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function store(StoreProfileCourseRequest $request)
    {
        //return DB::table('cecy.courses')->find($request->input('course.id'));
        //return Course::where([['id','=',$request->input('course.id')]])->first();

        $courseProfile = new courseProfile();
        $courseProfile->course_id = $request->input('course.id');


        $courseProfile->required_experiences = $request->input('requiredExperiences');
        $courseProfile->required_knowledges = $request->input('requiredKnowledges');
        $courseProfile->required_skills = $request->input('requiredSkills');

        $courseProfile->save();

        return (new CourseProfileResource($courseProfile))
            ->additional([
                'msg' => [
                    'summary' => 'Perfil creado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    

    public function destroy(CourseProfile $courseProfile)
    {
        $courseProfile->delete();
        return (new CourseProfileResource($courseProfile))

            ->additional([
                'msg' => [
                    'summary' => 'Perfil eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    public function update(UpdateProfileCourseRequest $request,CourseProfile $courseProfile)
    {
        $courseProfile->course_id = $request->input('course.id');


        $courseProfile->required_experiences = $request->input('requiredExperiences');
        $courseProfile->required_knowledges = $request->input('requiredKnowledges');
        $courseProfile->required_skills = $request->input('requiredSkills');

        $courseProfile->save();

        return (new CourseProfileResource($courseProfile))

            ->additional([
                'msg' => [
                    'summary' => 'Perfil actualizado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
}


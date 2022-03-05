<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cecy\Course;
use App\Models\Cecy\Prerequisite;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteCollection;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteResource;
use App\Http\Requests\V1\Cecy\Prerequisites\DestroyPrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\StorePrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\UpdatePrerequisiteRequest;


class PrerequisiteController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:store-catalogues')->only(['store']);
    //     $this->middleware('permission:update-catalogues')->only(['update']);
    //     $this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    // }

    // PREREQUISITOS
    // Obtiene todos los prerequisitos para un curso
    // PrerequisteController
    public function getPrerequisites(Course $course)
    {
        $prerequisites = $course->prerequisites()->get();
        
        return (new PrerequisiteCollection($prerequisites))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    public function getPrerequisitesAll(Course $course)
    {
        return (new PrerequisiteCollection(Prerequisite::paginate(100)))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // Agrega prerequsitos para un curso
    // PrerequisteController
    public function storePrerequisite(Request $request, Course $course)
    {
        
        Prerequisite::where('course_id', $course->id)->delete();
        $prerequisites = $request->input('prerequisites');
        foreach ($prerequisites as $prerequisite) {
                $coursePrerequisite = Course::find($prerequisite);
                $newPrerequisite = new Prerequisite();
                $newPrerequisite->course()->associate($course);
                $newPrerequisite->prerequisite()->associate($coursePrerequisite);
                $newPrerequisite->save();
        }
        return (new PrerequisiteCollection([]))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // Actualiza el prerequisito para un curso
    // PrerequisteController
    public function updatePrerequisite(UpdatePrerequisiteRequest $request, Course $course, Prerequisite $prerequisite)
    {
        $prerequisite->prerequisite()->associate($request->input('prerequisite.id'));
        $prerequisite->save();
        return (new PrerequisiteResource($prerequisite))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // Eliminda los prerequisitos para un curso
    // PrerequisteController
    public function destroyPrerequisite(Course $course, Prerequisite $prerequisite)
    {
        $prerequisite->delete();
        return (new PrerequisiteResource($prerequisite))
            ->additional([
                'msg' => [
                    'summary' => 'Prerequisito Eliminado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    //Elimina varios prerequisitos de un curso
    // PrerequisteController
    public function destroysPrerequisites(DestroyPrerequisiteRequest $request)
    {
        $prerequisite = Prerequisite::whereIn('id', $request->input('ids'))->get();
        Prerequisite::destroy($request->input('ids'));

        return (new PrerequisiteCollection($prerequisite))
            ->additional([
                'msg' => [
                    'summary' => 'Prerequisitos Eliminados',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }


    /*
        Obtener los prerequisitos dado un curso
    */
    // PrerequisteController
    public function getPrerequisitesByCourse(Course $course)
    {
        $prerequisites = $course->prerequisite()->get();

        return (new PrerequisiteCollection($prerequisites))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
}

<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Prerequisites\DestroyPrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\StorePrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\UpdatePrerequisiteRequest;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteCollection;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteResource;
use App\Models\Cecy\Course;
use App\Models\Cecy\Prerequisite;
use Illuminate\Http\Request;


class PrerequisiteController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:store-catalogues')->only(['store']);
    //     $this->middleware('permission:update-catalogues')->only(['update']);
    //     $this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    // }

    // Obtiene los prerequisitos de un curso
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
            ])
            ->response()->setStatusCode(200);
    }

    // Agrega y actualiza los prerequsitos para un curso
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
            ])
            ->response()->setStatusCode(200);
    }

    // Elimina un prerequisito para un curso
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
            ])
            ->response()->setStatusCode(200);
    }

    // Actualiza el prerequisito para un curso
    // PrerequisteController
    // public function updatePrerequisite(UpdatePrerequisiteRequest $request, Course $course, Prerequisite $prerequisite)
    // {
    //     $prerequisite->prerequisite()->associate($request->input('prerequisite.id'));
    //     $prerequisite->save();
    //     return (new PrerequisiteResource($prerequisite))
    //         ->additional([
    //             'msg' => [
    //                 'summary' => 'success',
    //                 'detail' => '',
    //                 'code' => '200'
    //             ]
    //         ])
    //         ->response()->setStatusCode(200);
    // }
}

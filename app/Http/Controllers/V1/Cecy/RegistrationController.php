<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Participants\GetCoursesByParticipantRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Prerequisite;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteCollection;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteResource;
use App\Http\Requests\V1\Cecy\Prerequisites\DestroyPrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\StorePrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\UpdatePrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Registrations\IndexRegistrationRequest;
use App\Http\Resources\V1\Cecy\Participants\CoursesByParticipantCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Models\Cecy\Participant;

class RegistrationController extends Controller
{
 //Ver todos los cursos del estudiante en el cual esta matriculado
    // RegistrationController
    public function getCoursesByParticipant(GetCoursesByParticipantRequest $request)
    {
        $participant = Participant::firstWhere('user_id', $request->user()->id);
        $registrations = $participant->registrations()->where(['state' => function ($state) {
            $state->where('code', 'MATRICULADO');
        }])
            ->paginate($request->input('per_page'));

        return (new CoursesByParticipantCollection($registrations))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    public function recordsReturnedByRegistration(IndexRegistrationRequest $request)
    {
        $participant = Participant::firstWhere('user_id', $request->user()->id);
        $registrations = $participant->registrations()->get();

        return (new RegistrationResource($registrations))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
}
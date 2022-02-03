<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Certificates\ShowParticipantsRequest;
use App\Http\Requests\V1\Cecy\Participants\GetCoursesByParticipantRequest;
use App\Models\Cecy\Course;
use App\Http\Requests\V1\Cecy\Registrations\IndexRegistrationRequest;
use App\Http\Resources\V1\Cecy\Certificates\CertificateResource;
use App\Http\Resources\V1\Cecy\Participants\CoursesByParticipantCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Registration;
use App\Models\Core\File;

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

    //trae participantes matriculados
    // RegistrationController
    public function showParticipants(ShowParticipantsRequest $request, DetailPlanification $detailPlanification)
    {
        $responsibleCourse = course::where('course_id', $request->course()->id)->get();

        $registrations = $detailPlanification->registrations()
            ->paginate($request->input('per_page'));

        return (new CertificateResource($registrations))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    //Descargar matriz
    // RegistrationController
    public function downloadFile(Catalogue $catalogue, File $file)
    {
        $registratiton = Registration::find(1);

        return $catalogue->downloadFile($file);
    }

}
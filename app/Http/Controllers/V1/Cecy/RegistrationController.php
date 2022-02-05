<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Certificates\ShowParticipantsRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByNameRequest;
use App\Http\Requests\V1\Cecy\Participants\GetCoursesByParticipantRequest;
use App\Http\Requests\V1\Core\Files\UploadFileRequest;
use App\Http\Resources\V1\Cecy\Registrations\RegisterStudentCollection;
use App\Models\Cecy\Course;
use App\Http\Requests\V1\Cecy\Registrations\IndexRegistrationRequest;
use App\Http\Resources\V1\Cecy\Certificates\CertificateResource;
use App\Http\Resources\V1\Cecy\Participants\CoursesByParticipantCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationRecordCompetitorResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Http\Resources\V1\Cecy\Users\UserResource;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Registration;
use App\Models\Core\File;
use http\Env\Request;

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
    /*DDRC-C: Anular varias Matriculas */
    // RegistrationController
    public function nullifyRegistrations(Request $request)
    {
        $registrations = Registration::whereIn('id', $request->input('ids'))->get();
        $registrations->state()->associate(Catalogue::find($request->input('state.id')));

        return (new RegistrationCollection($registrations))
            ->additional([
                'msg' => [
                    'summary' => 'Matriculas Anuladas',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }


    /*DDRC-C: elimina una matricula de un participante en un curso especifico */
    // RegistrationController
    public function nullifyRegistration(Registration $registration, Request $request)
    {
        $registrations = Registration::whereIn('id', $request->input('id'))->get();
        $registrations->state()->associate(Catalogue::find($request->input('state.id')));

        return (new UserResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'Matrícula Anulada',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

       // RegistrationController
       public function showRecordCompetitor(GetCoursesByNameRequest $request, Course $course)
       {
           //trae todos los participantes registrados de un curso en especifico
           $planification = $course->planifications()->get();
           $detailPlanification = $planification->detailPlanifications()->get();
           $registrations = $detailPlanification->registrations()->get();
           /*        $aditionalInformation= $registrations->aditionalInformations()->get();
                  $participant = $aditionalInformation->registrations()->get()
                  ->participants()
                  ->users();
           */
           /*  $Course = Planification::where('course_id', $request->course()->id)->get(); */

           /*         $registration = $registrations
                       ->planifications()
                       ->detailPlanifications()
                       ->additionalInformations()
                       ->users()
                       ->participants()
                       ->registrations()
                        ->course()
                       ->paginate($request->input('per_page')); */

           return (new RegistrationRecordCompetitorResource($registrations))
               ->additional([
                   'msg' => [
                       'summary' => 'success',
                       'detail' => '',
                       'code' => '200'
                   ]
               ])
               ->response()->setStatusCode(200);
       }
    //estudiantes de un curso y sus notas
    // RegistrationController
    public function ShowParticipantGrades(ShowParticipantsRequest $request, DetailPlanification $detailPlanification)
    {
        $registrations = $detailPlanification->registrations()->paginate();

        return (new RegisterStudentCollection($registrations))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
    //subir notas de los estudiantes
    // RegistrationController
    public function uploadFile(UploadFileRequest $request, FIle $file)
    {
        return $file->uploadFile($request);
    }
    //descargar plantilla de las notas
    // RegistrationController
    public function downloadFileGrades(Catalogue $catalogue, File $file)
    {
        return $catalogue->downloadFile($file);
    }
    //previsualizar la platilla de notas
    // RegistrationController
    public function showFile(Catalogue $catalogue, File $file)
    {
        return $catalogue->showFile($file);
    }

    //eliminar el archivo existente para poder cargar de nuevo
    // RegistrationController
    public function destroyFile(Catalogue $catalogue, File $file)
    {
        return $catalogue->destroyFile($file);
    }

}
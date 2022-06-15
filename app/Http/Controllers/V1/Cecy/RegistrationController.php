<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Core\Files\UploadFileRequest;
use App\Http\Requests\V1\Cecy\Certificates\ShowParticipantsRequest;
use App\Http\Requests\V1\Cecy\Courses\GetCoursesByNameRequest;
use App\Http\Requests\V1\Cecy\Participants\GetCoursesByParticipantRequest;
use App\Http\Requests\V1\Cecy\Registrations\RegisterStudentRequest;
use App\Http\Requests\V1\Cecy\Registrations\IndexRegistrationRequest;
use App\Http\Requests\V1\Cecy\Registrations\NullifyParticipantRegistrationRequest;
use App\Http\Requests\V1\Cecy\Registrations\NullifyRegistrationRequest;
use App\Http\Resources\V1\Cecy\Registrations\RegisterStudentCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegisterStudentResource;
use App\Http\Resources\V1\Cecy\Certificates\CertificateResource;
use App\Http\Resources\V1\Cecy\Participants\CoursesByParticipantCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationRecordCompetitorResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Http\Resources\V1\Cecy\Users\UserResource;
use App\Models\Authentication\User;
use App\Models\Cecy\AdditionalInformation;
use App\Models\Core\Catalogue as CoreCatalogue;
use App\Models\Core\File;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Registration;
use http\Env\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;


class RegistrationController extends Controller
{
    public function additionalInformation(Registration $registration){
        $additionalInformation=$registration->additionalInformation()->get();
    }

    //Ver todos los cursos del estudiante en el cual esta matriculado
    // RegistrationController
    public function getCoursesByParticipant(GetCoursesByParticipantRequest $request)
    {
        // $catalogues = Catalogue::where(["code" => "APPROVED", "type" => "PARTICIPANT_STATE"])->get();
        $participant = Participant::where('user_id', $request->user()->id)->first();
        /*if (!isset($participant))
            return response()->json([
                'msg' => [
                    'sumary' => 'Este usuario no es participante',
                    'detail' => '',
                    'code' => '404'
                ],
                'data'=>null
            ],404);*/
        $registrations = $participant->registrations()->paginate($request->input('per_page'));

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

    //participantes de un curso por detalle de la planificacion
    public function getParticipant(DetailPlanification $detailPlanification)
    {
        $registration = $detailPlanification->registrations()->get();
        return (new RegistrationCollection($registration))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'records' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    //recuperar las matriculas
    public function recordsReturnedByRegistration(IndexRegistrationRequest $request)
    {
        //dd($request->user()->id);

        $participant = Participant::firstWhere('user_id', $request->user()->id);
        $registrations = $participant->registrations()->get("number", "id");

        return (new RegistrationCollection($registrations))
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
    public function nullifyRegistrations(NullifyRegistrationRequest $request)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['cancelled']);

        // DDRC-C:recorre las ids enviadas para anularlas
        foreach ($request->ids as $registration => $value) {
            $registration = Registration::firstWhere('id', $value);
            $detailPlanification = $registration->detailPlanification;

            $registration->observations = $request->input('observations');
            $registration->state()->associate(Catalogue::find($currentState->id));

            $remainingRegistrations = $registration->detailPlanification->registrations_left;
            $detailPlanification->registrations_left = $remainingRegistrations + 1;

            DB::transaction(function () use ($registration, $detailPlanification) {

                $detailPlanification->save();
                $registration->save();
            });
        }
        // DDRC-C:recupera los ids modificadas para enviarlas de nuevo
        $registrations = Registration::whereIn('id', $request->input('ids'))->get();
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


    /*DDRC-C: anula una matricula de un participante en un curso especifico */
    // RegistrationController
    public function nullifyRegistration(NullifyParticipantRegistrationRequest $request, Registration $registration)
    {

        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['cancelled']);
        $detailPlanification = $registration->detailPlanification;

        $registration->observations = $request->input('observations');
        $registration->state()->associate(Catalogue::find($currentState->id));

        $remainingRegistrations = $registration->detailPlanification->registrations_left;
        $detailPlanification->registrations_left = $remainingRegistrations + 1;

        DB::transaction(function () use ($registration, $detailPlanification) {

            $detailPlanification->save();
            $registration->save();
        });

        return (new RegistrationResource($registration))
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
    public function showRecordCompetitor(GetCoursesByNameRequest $request, DetailPlanification $detailPlanification, AdditionalInformation $additionalInformation)
    {
        //trae todos los participantes registrados de un curso en especifico

        $planification=$detailPlanification->planification()->first();
        $course=$planification->course()->first();
        $regitrations=$detailPlanification->registrations()->with(['participant.user.sex','state','additionalInformation.levelInstruction'])->get();
        $classroom = $detailPlanification->classroom()->first();

        $pdf = PDF::loadView('reports/report-record-competitors', [
            'planification' => $planification,
            'detailPlanification' => $detailPlanification,
            'registrations' => $regitrations,
            'course'=>$course,
            'clasrroom'=>$classroom,


        ]);
        $pdf->setOptions([
            'orientation' => 'landscape',
        ]);
        return $pdf->stream('reporte registro participantes.pdf', []);
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
            ])
            ->response()->setStatusCode(200);
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
    // registrar estudiante al curso con la informacion adicional

    public function registerStudent(RegisterStudentRequest $request)
    {
        $participant = Participant::firstWhere('user_id', $request->user()->id);

        $registration = new Registration();
        $registration->participant()->associate($participant);
        $registration->type()->associate(Catalogue::find($request->input('type.id')));
        $registration->state()->associate(Catalogue::find($request->input('state.id')));
        $registration->typeParticipant()->associate(Catalogue::find($request->input('type_participant.id')));
        $registration->number = $request->input('number');
        $registration->registered_at = $request->input('registeredAt');

        DB::transaction(function ($registration, $request) {
            $registration->save();
            $additionalInformation = $this->storeAdditionalInformation($request, $registration);
            $additionalInformation->save();
        });

        return (new RegisterStudentResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    // llenar informacion adicional de la solicitud de matricula
    private function storeAdditionalInformation(RegisterStudentRequest $request, Registration $registration)
    {
        $additionalInformation = new AdditionalInformation();

        $additionalInformation->registration()->associate($registration);

        $additionalInformation->levelInstruction()->associate(Catalogue::find($request->input('level_instruction.id')));
        $additionalInformation->worked = $request->input('worked');
        $additionalInformation->company_activity = $request->input('companyActivity');
        $additionalInformation->company_address = $request->input('companyAddress');
        $additionalInformation->company_email = $request->input('companyEmail');
        $additionalInformation->company_name = $request->input('companyName');
        $additionalInformation->company_phone = $request->input('companyPhone');
        $additionalInformation->company_sponsored = $request->input('companySponsored');
        $additionalInformation->contact_name = $request->input('contactName');
        $additionalInformation->course_knows = $request->input('courseKnows');
        $additionalInformation->course_follows = $request->input('courseFollows');

        return $additionalInformation;
    }

    public function updateGradesParticipant(HttpRequest $request, Registration $registration)
    {
        $registration->grade1 = $request->input('grade1');
        $registration->grade2 = $request->input('grade2');
        $registration->final_grade = $request->input('final_grade');
        $registration->save();
        return (new RegistrationResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'registro Actualizado',
                    'Institution' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
}

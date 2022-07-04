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
use App\Http\Requests\V1\Cecy\Registrations\RegistrationRequest;
use App\Http\Requests\V1\Cecy\Registrations\ReviewRequest;
use App\Http\Requests\V1\Cecy\Registrations\NullifyRegistrationRequest;
use App\Http\Requests\V1\Core\Files\DestroysFileRequest;
use App\Http\Requests\V1\Core\Files\IndexFileRequest;
use App\Http\Requests\V1\Core\Files\UpdateFileRequest;
use App\Http\Resources\V1\Cecy\Registrations\RegisterStudentResource;
use App\Http\Resources\V1\Cecy\Certificates\CertificateResource;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationParticipants\DetailPlanificationParticipantResource;
use App\Http\Resources\V1\Cecy\Participants\CoursesByParticipantCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Http\Resources\V1\Cecy\Registrations\ParticipantRegistrationResource;
use App\Models\Cecy\AdditionalInformation;
use App\Models\Cecy\DetailSchoolPeriod;
use App\Models\Core\File;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Registration;
use App\Models\Cecy\Requirement;
use Carbon\Carbon;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;


class RegistrationController extends Controller
{
    public function additionalInformation(Registration $registration)
    {
        $additionalInformation = $registration->additionalInformation()->get();
    }

    //Ver todos los cursos del estudiante en el cual esta matriculado
    // RegistrationController
    public function getCoursesByParticipant(GetCoursesByParticipantRequest $request)
    {
        $participant = Participant::where('user_id', $request->user()->id)->first();
        if (!isset($participant))
            return response()->json([
                'msg' => [
                    'sumary' => 'Este usuario no es participante',
                    'detail' => '',
                    'code' => '404'
                ],
                'data' => null
            ], 404);
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

    public function show(Registration $registration)
    {
        // datos de un registro
        return (new DetailPlanificationParticipantResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }


    //participantes de un curso por detalle de la planificacion
    public function getParticipantByDetailPlanification(DetailPlanification $detailPlanification)
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


    //Descargar matriz
    // RegistrationController
    public function downloadFile(Catalogue $catalogue, File $file)
    {
        $registratiton = Registration::find(1);

        return $catalogue->downloadFile($file);
    }



    public function reEnroll(RegistrationRequest $request, Registration $registration)
    {
        // DDRC-C: rematricula a un participante
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['registered']);
        $registration->observations = "";
        $registration->state()->associate(Catalogue::find($currentState->id));
        $registration->save();
        return (new RegistrationResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Rematriculación exitosa',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function eliminate(Registration $registration)
    {
        // DDRC-C: elimina logicamente una incripción
        $registration->delete();
        return (new RegistrationResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Matricula Eliminada',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function register(RegistrationRequest $request, Registration $registration)
    {
        // DDRC-C: matricular a un participante
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['registered']);
        $registration->observations = $request->input('observations');
        $registration->state()->associate(Catalogue::find($currentState->id));
        $registration->save();
        return (new RegistrationResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Matriculación exitosa',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function setRegistrationinReview(ReviewRequest $request, Registration $registration)
    {
        // DDRC-C: cambia el estado a 'en revición' de una incripción
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['in_review']);
        $registration->observations = $request->input('observations');
        $registration->state()->associate(Catalogue::find($currentState->id));
        $registration->save();
        return (new RegistrationResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Cambio de estado exitoso',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    public function nullifyRegistrations(NullifyRegistrationRequest $request)
    {
        //DDRC-C: cancela varias Matriculas */
        // RegistrationController
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['cancelled']);

        // DDRC-C:recorre las ids enviadas para anularlas
        foreach ($request->ids as $registration => $value) {
            $registration = Registration::firstWhere('id', $value);
            $detailPlanification = $registration->detailPlanification;

            $registration->observations = $request->input('observations');
            $registration->state()->associate($currentState);

            $remainingRegistrations = $registration->detailPlanification->capacity;
            $detailPlanification->capacity = $remainingRegistrations + 1;

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


    public function nullifyRegistration(NullifyParticipantRegistrationRequest $request, Registration $registration)
    {
        //DDRC-C: cancela una matricula de un participante en un curso especifico
        // RegistrationController

        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['cancelled']);
        $detailPlanification = $registration->detailPlanification;

        $registration->observations = $request->input('observations');
        $registration->state()->associate(Catalogue::find($currentState->id));

        $remainingRegistrations = $registration->detailPlanification->capacity;
        $detailPlanification->capacity = $remainingRegistrations + 1;

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

    // identificar el tipo de matricula
    private function check(DetailSchoolPeriod $detailSchoolPeriod)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $currentDate = Carbon::now();
        $ordinaryStartedAt = Carbon::create($detailSchoolPeriod->ordinary_started_at);
        $ordinaryEndedAt = Carbon::create($detailSchoolPeriod->ordinary_ended_at);
        $extraordinaryStartedAt = Carbon::create($detailSchoolPeriod->extraordinary_started_at);
        $extraordinaryEndedAt = Carbon::create($detailSchoolPeriod->extraordinary_ended_at);
        $especialStartedAt = Carbon::create($detailSchoolPeriod->especial_started_at);
        $especialEndedAt = Carbon::create($detailSchoolPeriod->especial_ended_at);

        if ($currentDate->greaterThanOrEqualTo($ordinaryStartedAt)
            && $currentDate->greaterThanOrEqualTo($ordinaryEndedAt)) {
                return $catalogue['registration']['ordinary'];
        }
        if ($currentDate->greaterThanOrEqualTo($extraordinaryStartedAt)
            && $currentDate->greaterThanOrEqualTo($extraordinaryEndedAt)) {
                return $catalogue['registration']['extraordinary'];
        }
        if ($currentDate->greaterThanOrEqualTo($especialStartedAt)
            && $currentDate->greaterThanOrEqualTo($especialEndedAt)) {
                return $catalogue['registration']['special'];
        }
    }

    private function storeAdditionalInformation(RegisterStudentRequest $request, Registration $registration)
    {
        $additionalInformation = new AdditionalInformation();

        $additionalInformation->registration()->associate($registration);
        $additionalInformation->levelInstruction()->associate(Catalogue::find($request->input('levelInstruction.id')));
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

    // registrar estudiante al curso con la informacion adicional
    public function registerStudent(RegisterStudentRequest $request)
    {
        $participant = Participant::firstWhere('user_id', $request->user()->id);
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $state = Catalogue::firstWhere('code', $catalogue['registration_state']['in_review']);

        $detailPlanification = DetailPlanification::find($request->input('detailPlanificationId'));

        $planification = $detailPlanification->planification()->first();

        $detailSchoolPeriod = $planification->detailSchoolPeriod()->first();

        $registrationType = Catalogue::firstWhere('code', $this->check($detailSchoolPeriod));

        $registration = new Registration();
        $registration->participant()->associate($participant);
        $registration->detailPlanification()->associate($detailPlanification);
        $registration->type()->associate($registrationType);
        $registration->state()->associate($state);
        $registration->typeParticipant()->associate($participant->type);
        $registration->registered_at = now();

        DB::transaction(function () use($registration, $request) {
            $registration->save();
            $additionalInformation = $this->storeAdditionalInformation($request, $registration);
            $additionalInformation->save();
        });

        return (new RegisterStudentResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'Registro realizado con éxito',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    public function showRecordCompetitor(IndexRegistrationRequest $request, DetailPlanification $detailPlanification, AdditionalInformation $additionalInformation)
    {

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

    // llenar informacion adicional de la solicitud de matricula


    public function updateGradesParticipant(HttpRequest $request, Registration $registration)
    {
        $registration->grade1 = $request->input('grade1');
        $registration->grade2 = $request->input('grade2');
//        $registration->final_grade = $request->input('finalGrade');//calculado
        $registration->save();
        $this->FinalGrade($request, $registration);
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
    //nota final del estudiante
    public function FinalGrade(HttpRequest $request,Registration $registration){

        $grade1 =  $registration->grade1 = $request->input('grade1');
        $grade2 =  $registration->grade2 = $request->input('grade2');
        $registration->final_grade = ($grade1+$grade2) / 2;
        $registration->save();
        return (new RegistrationResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'nota final actualizada',
                    'Institution' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);



    }


    // Files
    public function indexFiles(IndexFileRequest $request, Registration $registration)
    {
        return $registration->indexFiles($request);
    }

    public function uploadFileA(UploadFileRequest $request, Registration $registration)
    {
        return $registration->uploadFile($request);
    }

    public function downloadFileA(Registration $registration, File $file)
    {
        return $registration->downloadFile($file);
    }

    public function showFileR(Registration $registration, File $file)
    {
        return $registration->showFile($file);
    }

    public function updateFile(UpdateFileRequest $request, Registration $registration, File $file)
    {
        return $registration->updateFile($request, $file);
    }

    public function destroyFileA(Registration $registration, File $file)
    {
        return $registration->destroyFile($file);
    }

    public function destroyFiles(Registration $registration, DestroysFileRequest $request)
    {
        return $registration->destroyFiles($request);
    }

}

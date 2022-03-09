<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Participants\StoreParticipantUserRequest;
use App\Http\Requests\V1\Cecy\Planifications\IndexPlanificationRequest;
use App\Http\Requests\V1\Cecy\Registrations\IndexRegistrationRequest;
use App\Http\Requests\V1\Cecy\Registrations\RegisterParticipantRequest;
use App\Http\Requests\V1\Cecy\Registrations\RegisterStudentRequest;
use App\Http\Requests\V1\Cecy\Registrations\RegistrationStateModificationRequest;
use App\Http\Requests\V1\Cecy\Registrations\UpdateRegistrationRequest;
use App\Http\Resources\V1\Cecy\Participants\ParticipantInformationResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationParticipants\PlanificationParticipantCollection;
use App\Http\Resources\V1\Cecy\Registrations\RegisterParticipantResource;
use Illuminate\Http\Request;
use App\Models\Cecy\Catalogue;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Http\Resources\V1\Core\Users\UserResource;
use App\Models\Authentication\User;
use App\Models\Cecy\AdditionalInformation;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Planification;
use App\Models\Cecy\Registration;
use App\Models\Core\Address;
use App\Models\Core\Catalogue as CoreCatalogue;
use App\Models\Core\File;
use App\Models\Core\Image;
use App\Models\Core\Location;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    public function __construct()
    {
    }

    // ParticipantController
    public function registerParticipantUser(StoreParticipantUserRequest $request)
    {

        $user = User::where('username', $request->input('username'))
            ->orWhere('email', $request->input('email'))->first();

        if (isset($user) && $user->username === $request->input('username')) {
            return (new UserResource($user))
                ->additional([
                    'msg' => [
                        'summary' => 'El usuario ya se encuentra registrado',
                        'detail' => 'Intente con otro nombre de usuario',
                        'code' => '200'
                    ]
                ])
                ->response()->setStatusCode(400);
        }

        if (isset($user) && $user->email === $request->input('email')) {
            return (new UserResource($user))
                ->additional([
                    'msg' => [
                        'summary' => 'El correo electrónico ya está en uso',
                        'detail' => 'Intente con otro correo electrónico',
                        'code' => '200'
                    ]
                ])->response()->setStatusCode(400);
        }

        $user = new User();
        $user->identificationType()->associate(CoreCatalogue::find($request->input('identificationType.id')));
        $user->disability()->associate(CoreCatalogue::find($request->input('disability.id')));
        $user->gender()->associate(CoreCatalogue::find($request->input('gender.id')));
        $user->nationality()->associate(Location::find($request->input('nationality.id')));
        $user->ethnicOrigin()->associate(CoreCatalogue::find($request->input('ethnicOrigin.id')));
        $user->address()->associate($this->createUserAddress($request->input('address')));
        // $user->bloodType()->associate(Catalogue::find($request->input('bloodType.id')));
        // $user->civilStatus()->associate(Catalogue::find($request->input('civilStatus.id')));
        // $user->sex()->associate(Catalogue::find($request->input('sex.id')));

        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->lastname =  $request->input('lastname');
        $user->birthdate = $request->input('birthdate');
        $user->email = $request->input('email');
        $user->password =  '12345678';

        DB::transaction(function () use ($request, $user) {
            $user->save();
            $user->addPhones($request->input('phones'));
            $user->addEmails($request->input('emails'));
            $participant = $this->createParticipant($request->input('participantType.id'), $user);
            $participant->save();
        });

        return (new UserResource($user))
            ->additional([
                'msg' => [
                    'summary' => 'Participante Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }


    private function createUserAddress($addressUser)
    {
        $address =  new Address();
        $address->location()->associate(Location::find($addressUser['cantonLocation']['id']));
        $address->sector()->associate(CoreCatalogue::find(1));
        $address->main_street =  $addressUser['mainStreet'];
        $address->secondary_street =  $addressUser['secondaryStreet'];
        return $address;
    }

    private function createParticipant($participantTipeId, User $user)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $state = Catalogue::where('type',  $catalogue['participant_state']['type'])
            ->where('code', $catalogue['participant_state']['to_be_approved'])->first();

        $participant = new Participant();
        $participant->user()->associate($user);
        $participant->type()->associate(Catalogue::find($participantTipeId));
        $participant->state()->associate($state);
        return $participant;
    }

    public function showFileInstructor(User $user, File $file)
    {
        return $user->showFile($file);
    }

    public function showImageInstructor(User $user, Image $image)
    {
        return $user->showImage($image);
    }
    /*DDRC-C: Busca los participantes inscritos a una planificación especifica*/
    // ParticipantController
    public function getParticipantsByPlanification(IndexPlanificationRequest $request, DetailPlanification $detailPlanification)
    {

        $detailPlanifications = DetailPlanification::firstwhere('planification_id', $detailPlanification->id);

        $participants = Registration::where('detail_planification_id', $detailPlanification->id)
            ->paginate($request->input('per_page'));
        // return $participants;
        return (new PlanificationParticipantCollection($participants))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }
    /*DDRC-C: Busca informacion de un participante(datos del usuario) y de registro a un curso especifico(informacion adicional y archivos)*/
    // ParticipantController
    public function getParticipantInformation(IndexRegistrationRequest $request, Registration $registration)
    {
        // $participantRegistration = Registration::firstWhere('id', $registration->id);
        // $additionalInformation = AdditionalInformation::firstwhere('registration_id', $registration->id);
        return (new ParticipantInformationResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    /*DDRC-C: actualiza una inscripcion, cambiando la observacion,y estado de una inscripción de un participante en un curso especifico  */
    // ParticipantController
    public function participantRegistrationStateModification(RegistrationStateModificationRequest $request, Registration $registration)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        if (($request->observations === null || $request->observations === '' ) &&
        ($registration->state->code !== 'REGISTERED' || $registration->state->code !== 'CANCELLED')) {
            $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['registered']);
            $registration->observations = $request->input('observations');
            $registration->state()->associate(Catalogue::find($currentState->id));
            $registration->save();
        } elseif ($registration->state->code === 'RECTIFIED' || $registration->state->code === 'SIGNED_IN' || $registration->state->code === 'IN_REVIEW') {
            $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['in_review']);
            $registration->observations = $request->input('observations');
            $registration->state()->associate(Catalogue::find($currentState->id));
            $registration->save();
        } elseif($registration->state->code === 'REGISTERED'){
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'failed',
                    'detail' => 'El usuario ya esta matriculado.',
                    'code' => '400'
                ]
            ], 400);
        } elseif($registration->state->code === 'CANCELLED'){
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'failed',
                    'detail' => 'La matricula se encuentra anulada.',
                    'code' => '400'
                ]
            ], 400);
        }

        return (new RegistrationResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Proceso exitoso',
                    'code' => '201'
                ]
            ])->response()->setStatusCode(201);
    }

    /*DDRC-C: Matricula un participante */
    // ParticipantController
    public function registerParticipant(RegistrationStateModificationRequest $request, Participant $participant)
    {
        $registration = $participant->registration()->first();
        $registration->state()->associate(Catalogue::find($request->input('state.id')));
        $registration->save();

        return (new RegistrationResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'Participantes matriculados',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    /*DDRC-C: notifica a un participante de una observacion en su inscripcion*/
    // ParticipantController
    // Pendiente
    public function notifyParticipant()
    {
        //TODO: revisar sobre el envio de notificaciones
        return 'por revisar';
    }
}

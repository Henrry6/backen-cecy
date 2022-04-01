<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\V1\Cecy\Participants\AcceptParticipantRequest;
use App\Http\Requests\V1\Cecy\Participants\DestroyParticipantRequest;
use App\Http\Requests\V1\Cecy\Participants\IndexParticipantRequest;
use App\Http\Requests\V1\Cecy\Participants\UpdateParticipantRequest;
use App\Http\Requests\V1\Cecy\Participants\StoreParticipantRequest;
use App\Http\Requests\V1\Cecy\Planifications\IndexPlanificationRequest;
use App\Http\Requests\V1\Cecy\Participants\StoreParticipantUserRequest;
use App\Http\Resources\V1\Cecy\Participants\ParticipantCollection;
use App\Http\Resources\V1\Cecy\Participants\ParticipantResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationParticipants\PlanificationParticipantCollection;
use App\Http\Requests\V1\Cecy\Registrations\RegistrationStateModificationRequest;
use App\Http\Resources\V1\Core\Users\UserResource;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Models\Authentication\User;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Registration;
use App\Models\Core\Address;
use App\Models\Core\Catalogue as CoreCatalogue;
use App\Models\Core\File;
use App\Models\Core\Image;
use App\Models\Core\Location;

class ParticipantController extends Controller
{
    public function __construct()
    {
    }

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
                ->response()->setStatusCode(200);
        }

        if (isset($user) && $user->email === $request->input('email')) {
            return (new UserResource($user))
                ->additional([
                    'msg' => [
                        'summary' => 'El correo electrónico ya está en uso',
                        'detail' => 'Intente con otro correo electrónico',
                        'code' => '200'
                    ]
                ])->response()->setStatusCode(200);
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

    public function getParticipantsByPlanification(IndexPlanificationRequest $request, DetailPlanification $detailPlanification)
    {
        // return Registration::firstWhere('detail_planification_id', $detailPlanification->id)->requirements('yolo');


        $participants = Registration::where('detail_planification_id', $detailPlanification->id)
            ->paginate($request->input('per_page'));

        return (new PlanificationParticipantCollection($participants))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }


    /*DDRC-C: actualiza una inscripcion, cambiando la observacion,y estado de una inscripción de un participante en un curso especifico  */
    // ParticipantController
    public function participantRegistrationStateModification(RegistrationStateModificationRequest $request, Registration $registration)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        if (($request->observations === null || $request->observations === '') &&
            ($registration->state->code !== 'REGISTERED' || $registration->state->code !== 'CANCELLED')
        ) {
            $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['registered']);
            $registration->observations = $request->input('observations');
            $registration->state()->associate(Catalogue::find($currentState->id));
            $registration->save();
        } elseif ($registration->state->code === 'RECTIFIED' || $registration->state->code === 'SIGNED_IN' || $registration->state->code === 'IN_REVIEW') {
            $currentState = Catalogue::firstWhere('code', $catalogue['registration_state']['in_review']);
            $registration->observations = $request->input('observations');
            $registration->state()->associate(Catalogue::find($currentState->id));
            $registration->save();
        } elseif ($registration->state->code === 'REGISTERED') {
            return response()->json([
                'data' => '',
                'msg' => [
                    'summary' => 'failed',
                    'detail' => 'El usuario ya esta matriculado.',
                    'code' => '400'
                ]
            ], 400);
        } elseif ($registration->state->code === 'CANCELLED') {
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
            ])
            ->response()->setStatusCode(201);
    }

    public function notifyParticipant()
    {
        //TODO: revisar sobre el envio de notificaciones
        return 'por revisar';
    }

    //Creación de Participante
    public function createParticipantUser(StoreParticipantUserRequest $request){
        $user = User::where('username', $request->input('username'))
        ->orWhere('email', $request->input('email'))->first();

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

    //Modificacion de Participante
    public function updateParticipant(UpdateParticipantRequest $request, Participant $participant)
    {
        $user= $participant -> user();
        $participant->identificationType()->associate(Catalogue::find($request->input('identificationType.id')));
        $participant->sex()->associate(Catalogue::find($request->input('sex.id')));
        $participant->gender()->associate(Catalogue::find($request->input('gender.id')));
        $participant->bloodType()->associate(Catalogue::find($request->input('bloodType.id')));
        $participant->ethnicOrigin()->associate(Catalogue::find($request->input('ethnicOrigin.id')));
        $participant->civilStatus()->associate(Catalogue::find($request->input('civilStatus.id')));

        $participant->username = $request->input('username');
        $participant->name = $request->input('name');
        $participant->lastname = $request->input('lastname');
        $participant->birthdate = $request->input('birthdate');

        $participant->save();

        return (new UserResource($participant))
            ->additional([
                'msg' => [
                    'summary' => 'Datos Actualizados',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    //Metodo para ver listado de los Participante
    public function index (IndexParticipantRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $participants = Participant::customOrderBy($sorts)
            // ->username($request->input('search'))
            ->paginate($request->input('perPage'));

        return (new ParticipantCollection($participants))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    //Metodo de Aceptación de Participante
    public function acceptParticipant(AcceptParticipantRequest $request, Participant $participant)
    {
        $participant->state_id = $request->id;
        $participant->save();

        return (new ParticipantResource($participant))
            ->additional([
                'msg' => [
                    'summary' => 'Participante Aceptado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    //Metodo de Eliminación de Participante
    public function destroyParticipant(Participant $participant)
    {
        $participant->delete();

        return (new ParticipantResource($participant))
            ->additional([
                'msg' => [
                    'summary' => 'Participante Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    //Files
    public function showFileInstructor(User $user, File $file)
    {
        return $user->showFile($file);
    }
    //Images
    public function showImageInstructor(User $user, Image $image)
    {
        return $user->showImage($image);
    }
}

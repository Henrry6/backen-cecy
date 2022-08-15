<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\V1\Cecy\Participants\AcceptParticipantRequest;
use App\Http\Requests\V1\Cecy\Participants\DestroyParticipantRequest;
use App\Http\Requests\V1\Cecy\Participants\IndexParticipantRequest;
use App\Http\Requests\V1\Cecy\Participants\UpdateParticipantRequest;
use App\Http\Requests\V1\Cecy\Participants\UpdateParticipantUserRequest;
//use App\Http\Requests\V1\Cecy\Participants\StoreParticipantRequest;
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
use Illuminate\Http\Request;

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
                        'summary' => 'El número de cedula ingresada ya se encuentra registrada',
                        'detail' => 'Intente con otro número de cedula',
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


        $user->phone = $request->input('phone');
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->birthdate = $request->input('birthdate');
        $user->email = $request->input('email');
        $user->password = '12345678';

        DB::transaction(function () use ($request, $user) {
            $user->save();
            $user->addEmails($request->input('emails'));
            $participant = $this->createParticipant($request->input('participantType.id'), $user);
            $participant->save();
        });

        return (new UserResource($user))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    private function createUserAddress($addressUser)
    {
        $address = new Address();
        $address->location()->associate(Location::find($addressUser['cantonLocation']['id']));
        $address->sector()->associate(CoreCatalogue::find(1));
        $address->main_street = $addressUser['mainStreet'];
        $address->secondary_street = $addressUser['secondaryStreet'];
        return $address;
    }

    private function createParticipant($participantTypeId, User $user)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $state = Catalogue::where('type', $catalogue['participant_state']['type'])
            ->where('code', $catalogue['participant_state']['approved'])->first();

        $participant = new Participant();

        $participant->user()->associate($user);
        $participant->type()->associate(Catalogue::find($participantTypeId));
        $participant->state()->associate($state);

        return $participant;
    }

    //se crear un nuevo participante por manos de administrador
    public function store(StoreParticipantUserRequest $request)
    {
        $user = new User();

        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = $request->input('username');
        $user->phone = $request->input('phone');

        $participant = null;

        DB::transaction(function () use ($request, $user) {
            $user->save();
            $participant = $this->createParticipant($request->input('type.id'), $user);
            $participant->save();
        });

        return (new ParticipantResource($participant))
            ->additional([
                'msg' => [
                    'summary' => 'Participante Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function update(UpdateParticipantUserRequest $request, Participant $participant)
    {
        $user = $participant->user()->first();

        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = $request->input('username');
        $user->phone = $request->input('phone');

        $user->save();

        return (new ParticipantResource($participant))
            ->additional([
                'msg' => [
                    'summary' => 'Datos Actualizados',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    /*public function updateParticipant($id , $user){

        return (new UserResource($user))
            ->additional([
                'msg' => [
                    'summary' => 'Datos Actualizados',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }*/


    //se para ver el listado de los participante
    public function index(IndexParticipantRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $participants = Participant::customOrderBy($sorts)
            ->user($request->input('userSearch'))
            ->paginate($request->input('per_page'));

        return (new ParticipantCollection($participants))
            ->additional([
                'msg' => [
                    'summary' => 'Éxito',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    //se cambia el estado de los participantes para su acceptación
    public function approveParticipant(Request $request, Participant $participant)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $state = Catalogue::where('type', $catalogue['participant_state']['type'])
            ->where('code', $catalogue['participant_state']['approved'])->first();

        $participant->state()->associate($state);
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

    public function declineParticipant(Request $request, Participant $participant)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $state = Catalogue::where('type', $catalogue['participant_state']['type'])
            ->where('code', $catalogue['participant_state']['not_approved'])->first();

        $participant->state()->associate($state);
        $participant->save();

        return (new ParticipantResource($participant))
            ->additional([
                'msg' => [
                    'summary' => 'Participante Rechazado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function destroy(DestroyParticipantRequest $request, Participant $participant)
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

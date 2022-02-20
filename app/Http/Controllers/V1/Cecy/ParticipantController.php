<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\DetailPlanifications\DetailPlanificationRequest;
use App\Http\Requests\V1\Cecy\Participants\StoreUserAndParticipantRequest;
use App\Http\Requests\V1\Cecy\Registrations\IndexRegistrationRequest;
use App\Http\Requests\V1\Cecy\Registrations\UpdateRegistrationRequest;
use App\Http\Resources\V1\Cecy\Participants\ParticipantInformationResource;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationParticipantCollection;
use Illuminate\Http\Request;
use App\Models\Cecy\Catalogue;
use App\Http\Resources\V1\Cecy\Registrations\RegistrationResource;
use App\Http\Resources\V1\Cecy\Users\UserResource;
use App\Models\Authentication\User;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Planification;
use App\Models\Cecy\Registration;
use App\Models\Core\File;
use App\Models\Core\Image;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    public function __construct()
    {
    }

    // ParticipantController
    public function registerUserParticipant(StoreUserAndParticipantRequest $request)
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
        $user->identificationType()->associate(Catalogue::find($request->input('identificationType.id')));
        $user->sex()->associate(Catalogue::find($request->input('sex.id')));
        $user->gender()->associate(Catalogue::find($request->input('gender.id')));
        $user->bloodType()->associate(Catalogue::find($request->input('bloodType.id')));
        $user->ethnicOrigin()->associate(Catalogue::find($request->input('ethnicOrigin.id')));
        $user->civilStatus()->associate(Catalogue::find($request->input('civilStatus.id')));

        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->birthdate = $request->input('birthdate');
        $user->email = $request->input('email');

        DB::transaction(function () use ($request, $user) {
            $user->save();
            $user->addPhones($request->input('phones'));
            $user->addEmails($request->input('emails'));
            $participant = $this->createParticipant($request, $user);
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

    private function createParticipant(StoreUserAndParticipantRequest $request, User $user)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $state = Catalogue::where('code', $catalogue['participant_state']['to_be_approved'])->get();

        $participant = new Participant();
        $participant->user()->associate($user);
        $participant->type()->associate(Catalogue::find($request->input('type.id')));
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
    public function getParticipantsByPlanification(DetailPlanificationRequest $request, Planification $planification)
    {
        $detailPlanifications = $planification->detailPlanifications()->get();

        $participants = Registration::whereIn('detail_planification_id', $detailPlanifications)
            ->paginate($request->input('per_page'));

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
    public function updateParticipantRegistration(UpdateRegistrationRequest $request, Registration $registration)
    {
        $registration->observation = $request->input('observation');
        $registration->state()->associate(Catalogue::find($request->input('state.id')));
        $registration->save();

        return (new RegistrationResource($registration))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '201'
                ]
            ])->response()->setStatusCode(201);
    }

    /*DDRC-C: Matricula un participante */
    // ParticipantController
    public function registerParticipant(Request $request, Participant $participant)
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

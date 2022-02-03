<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Participants\StoreUserAndParticipantRequest;
use App\Http\Requests\V1\Cecy\Topics\DestroysTopicRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\Topic;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Http\Resources\V1\Cecy\Topics\TopicResource;
use App\Http\Resources\V1\Cecy\Topics\TopicCollection;
use App\Http\Requests\V1\Cecy\Topics\StoreTopicRequest;
use App\Http\Requests\V1\Cecy\Topics\UpdateTopicRequest;
use App\Http\Resources\V1\Cecy\Courses\TopicsByCourseCollection;
use App\Http\Resources\V1\Cecy\Users\UserResource;
use App\Models\Authentication\User;
use App\Models\Cecy\Participant;
use App\Models\Core\File;
use App\Models\Core\Image;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    public function __construct()
    {
    }


    // ParticipantController
    public function registerParticipant(StoreUserAndParticipantRequest $request)
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
            $participant = $this->storeParticipant($request, $user);
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
}

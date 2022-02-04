<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Registrations\RegisterStudentRequest;
use App\Http\Resources\V1\Cecy\AdditionalInformations\AdditionalInformationResource;
use App\Http\Resources\V1\Cecy\Registrations\RegisterStudentResource;
use App\Models\Cecy\AdditionalInformation;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Registration;
use App\Models\Cecy\Requirement;
use Illuminate\Support\Facades\DB;

class DamianController extends Controller
{
    //inscripcion a un curso

    public function registerStudent(RegisterStudentRequest $request)
    {
        $participant = Participant::firstWhere('user_id', $request->user()->id);

        $registration = new Registration();
        $registration->participant()->associate($participant);
        $registration->type()->associate(Catalogue::find($request->input('type.id')));
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
            ]);
    }

    // llenar informacion adicional de la solicitud de matricula
    private function storeAdditionalInformation(RegisterStudentRequest $request, Registration $registration)
    {
        $additionalInformation = new AdditionalInformation();

        $additionalInformation->registration()->associate($registration);

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

    // enviar documentacion

    public function addFilesrequired()
    {
        return;
    }
    // ver los requisito
    public function getAllRequirement(getAllRequirementRequest $request)
    {

        $requirements = Requirement::paginate($request->per_page);

        return (new RequirementCollection($requirements))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // ver un requisito
    public function getRequirement(Requirement $requirement)
    {
        return (new RequirementResource($requirement))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // crear un requisito
    public function storeRequirement(Requirement $request)
    {
        $requirement = new Requirement();
        $requirement->state()
            ->associate(Catalogue::find($request->input('state.id')));
        $requirement-> name = $request -> input('name');
        $requirement-> required = $request -> input('required');
        $requirement->save();

        return(new RequirementResource($requirement))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
    // actualizar un requisito
    public function updateRequirement(Requirement $request, Requirement $requirement){

        $requirement->state()
            ->associate(Catalogue::find($request->input('state.id')));
        $requirement-> name = $request -> input('name');
        $requirement-> required = $request -> input('required');
        $requirement->save();
        return(new RequirementResource($requirement))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // crear un school periods


    // mostrar todos los school periods

    // crud detail periods
}




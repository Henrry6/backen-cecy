<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Core\Files\DestroysFileRequest;
use App\Http\Requests\V1\Core\Files\IndexFileRequest;
use App\Http\Requests\V1\Core\Files\UpdateFileRequest;
use App\Http\Requests\V1\Core\Files\UploadFileRequest;
use App\Http\Requests\V1\Cecy\AdditionalInformations\IndexAdditionalInformationRequest;
use App\Http\Requests\V1\Cecy\AdditionalInformations\StoreAdditionalInformationRequest;
use App\Http\Requests\V1\Cecy\AdditionalInformations\UpdateAdditionalInformationRequest;
use App\Http\Resources\V1\Cecy\AdditionalInformations\AdditionalInformationCollection;
use App\Http\Resources\V1\Cecy\AdditionalInformations\AdditionalInformationResource;
use App\Models\Core\File;
use App\Models\Cecy\AdditionalInformation;

class AdditionalInformationController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:store-additionalInformations')->only(['store']);
        //$this->middleware('permission:update-additionalInformations')->only(['update']);
        //$this->middleware('permission:delete-additionalInformations')->only(['destroy', 'destroys']);
    }

    public function index(IndexAdditionalInformationRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $additionalInformations = AdditionalInformation::customOrderBy($sorts)
            ->companyActivity($request->input('search'))
            ->companyAddress($request->input('search'))
            ->companyEmail($request->input('search'))
            ->companyName($request->input('search'))
            ->companyPhone($request->input('search'))
            ->contactName($request->input('search'))
            ->levelInstruction($request->input('search'))
            ->paginate($request->input('perPage'));

        return (new AdditionalInformationCollection($additionalInformations))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function show(AdditionalInformation $additionalInformation)
    {
        return (new AdditionalInformationResource($additionalInformation))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function store(StoreAdditionalInformationRequest $request)
    {
        $additionalInformation = new AdditionalInformation();

        $additionalInformation->registration()
            ->associate(AdditionalInformation::find($request->input('additionalInformation.id')));

        $additionalInformation->company_activity = $request->input('companyActivity');
        $additionalInformation->company_address = $request->input('companyAddress');
        $additionalInformation->company_email = $request->input('companyEmail');
        $additionalInformation->company_name = $request->input('companyName');
        $additionalInformation->company_phone = $request->input('companyPhone');
        $additionalInformation->company_sponsor = $request->input('companySponsor');
        $additionalInformation->contact_name = $request->input('contactName');
        $additionalInformation->level_instruction = $request->input('levelInstruction');
        $additionalInformation->course_know = $request->input('courseKnow');
        $additionalInformation->course_follow = $request->input('courseFollow');
        $additionalInformation->worked = $request->input('worked');

        $additionalInformation->save();

        return (new AdditionalInformationResource($additionalInformation))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Creado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function update(UpdateAdditionalInformationRequest $request, AdditionalInformation $additionalInformation)
    {
        $additionalInformation->registration()
            ->associate(AdditionalInformation::find($request->input('additionalInformation.id')));

        $additionalInformation->company_activity = $request->input('companyActivity');
        $additionalInformation->company_address = $request->input('companyAddress');
        $additionalInformation->company_email = $request->input('companyEmail');
        $additionalInformation->company_name = $request->input('companyName');
        $additionalInformation->company_phone = $request->input('companyPhone');
        $additionalInformation->company_sponsor = $request->input('companySponsor');
        $additionalInformation->contact_name = $request->input('contactName');
        $additionalInformation->level_instruction = $request->input('levelInstruction');
        $additionalInformation->course_know = $request->input('courseKnow');
        $additionalInformation->course_follow = $request->input('courseFollow');
        $additionalInformation->worked = $request->input('worked');

        $additionalInformation->save();

        return (new AdditionalInformationResource($additionalInformation))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Actualizado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function destroy(AdditionalInformation $additionalInformation)
    {
        $additionalInformation->delete();
        return (new AdditionalInformationResource($additionalInformation))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    // Files
    public function indexFiles(IndexFileRequest $request, AdditionalInformation $additionalInformation)
    {
        return $additionalInformation->indexFiles($request);
    }

    public function uploadFile(UploadFileRequest $request, AdditionalInformation $additionalInformation)
    {
        return $additionalInformation->uploadFile($request);
    }

    public function downloadFile(AdditionalInformation $additionalInformation, File $file)
    {
        return $additionalInformation->downloadFile($file);
    }

    public function showFile(AdditionalInformation $additionalInformation, File $file)
    {
        return $additionalInformation->showFile($file);
    }

    public function updateFile(UpdateFileRequest $request, AdditionalInformation $additionalInformation, File $file)
    {
        return $additionalInformation->updateFile($request, $file);
    }

    public function destroyFile(AdditionalInformation $additionalInformation, File $file)
    {
        return $additionalInformation->destroyFile($file);
    }

    public function destroyFiles(AdditionalInformation $additionalInformation, DestroysFileRequest $request)
    {
        return $additionalInformation->destroyFiles($request);
    }
}

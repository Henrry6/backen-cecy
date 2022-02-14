<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Certificates\IndexCertificateRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Prerequisite;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteCollection;
use App\Http\Resources\V1\Cecy\Prerequisites\PrerequisiteResource;
use App\Http\Requests\V1\Cecy\Prerequisites\DestroyPrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\StorePrerequisiteRequest;
use App\Http\Requests\V1\Cecy\Prerequisites\UpdatePrerequisiteRequest;
use App\Http\Requests\V1\Core\Files\UploadFileRequest;
use App\Models\Cecy\Registration;
use App\Models\Core\File;

class CertificateController extends Controller
{
    //Descargar certificado del curso
    // CertificateController
    public function downloadCertificateByParticipant(IndexCertificateRequest $request, Registration $registration, Catalogue $catalogue, File $file)
    {
        //$participant = Participant::firstWhere('user_id', $request->user()->id);
        $certificate = $registration->certificate()->where(['state' => function ($state) {
            $state->where('code', 'APPROVED')->first();
        }]);
        return $catalogue->downloadFileCertificates($file);
    }

    //Subir certificado Firmado
    // CerticateController
    public function uploadFileCertificateFirm(UploadFileRequest $request, Catalogue $catalogue)
    {

        return $catalogue->uploadFileCertificateFirm($request);
    }

    //Carga de codigos certificado excel
    // CerticateController
    public function uploadFileCertificate(UploadFileRequest $request, Catalogue $catalogue)
    {
        return $catalogue->uploadFileCertificate($request);
    }

    //Descarga de certificados generados
    // CerticateController
    public function downloadFileCertificates(Catalogue $catalogue, File $file)
    {
        return $catalogue->downloadFileCertificates($file);
    }
}

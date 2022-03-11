<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Models\Cecy\Certificate;
use App\Http\Requests\V1\Cecy\Certificates\IndexCertificateRequest;
use App\Models\Cecy\Catalogue;
use App\Http\Requests\V1\Core\Files\UploadFileRequest;
use App\Models\Cecy\Registration;
use App\Models\Core\File;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Imports\CertificatesImport;
use Maatwebsite\Excel\Facades\Excel;

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

   
    //CertificateController---devuelve datos de la tabla certificados

    public function ExcelData(){
    
    $certificate = Certificate::get();
    return $certificate;
    // return view('livewire.educacion.guia-para-pacientes-y-familias-component', ['educations' => $certificate]);

    }

     
    //CertificateController----Importa datos de la plantilla Excel 

    public function ExcelImport(){
      
        $file = request()->file('excel');

        if (!isset($file)) {
            echo 'No esta enviando el name del archivo, el nombre es excel';
            return;
        }
        Excel::import(new CertificatesImport, $file);
        echo 'Se importo correctamente';
    
        }

    //Genera PDF del estudiante 
    
    public function generatePdfStudent(){
    
     $pdf = PDF::loadView('reports/certificate-student');
     $pdf->setOptions([
            'orientation' => 'landscape',
            'page-size' => 'a4'
     ]);
            return $pdf->inline('CertificadoInstructor.pdf');
    }
    
    //Genera PDF del instructor

    public function generatePdfInstructor(){
    
     $pdf = PDF::loadView('reports/certificate-instructor');
     $pdf->setOptions([
         'orientation' => 'landscape',
         'page-size' => 'a4'
     ]);
            return $pdf->inline('CertificadoInstructor.pdf');
    }

    public function import (){
        return view('reports.certificate-student', "data");
    }

    public function importData(Request $request) {
        echo 'hola mundo';
        
    }
    

}

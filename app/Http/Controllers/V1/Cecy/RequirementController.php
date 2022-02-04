<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Models\Cecy\Requirement;
use App\Models\Core\File;
use App\Models\Core\Image;



class RequirementController extends Controller
{

    /*******************************************************************************************************************
     * FILES
     ******************************************************************************************************************/
    /*DDRC-C: ver documentos  requeridos para un registro */
    // RequirementController
    public function showFile(Requirement $Requirement, File $file)
    {
        return $Requirement->showFile($file);
    }


    /*******************************************************************************************************************
     * IMAGES
     ******************************************************************************************************************/
    /*DDRC-C: ver documentos  requeridos para un registro */
    // RequirementController
    public function showImage(Requirement $Requirement, Image $image)
    {
        return $Requirement->showImage($image);
    }

}

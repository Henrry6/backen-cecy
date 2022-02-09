<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Requirement;
use App\Models\Core\File;
use App\Models\Core\Image;



class RequirementController extends Controller
{
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
    //Eliminar un requisito
    public function destroy(Requirement $requirement)
    {
        $requirement->delete();
        return (new RequirementResource($requirement))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ]);
    }
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

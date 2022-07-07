<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Requirements\CatalogueRequirementRequest;
use App\Http\Requests\V1\Cecy\Requirements\DestroysRequirementRequest;
use App\Http\Requests\V1\Cecy\Requirements\IndexRequirementRequest;
use App\Http\Requests\V1\Cecy\Requirements\StoreRequirementRequest;
use App\Http\Requests\V1\Cecy\Requirements\UpdateRequirementRequest;
use App\Http\Resources\V1\Cecy\Requeriments\RequirementCollection;
use App\Http\Resources\V1\Cecy\Requeriments\RequirementResource;
use App\Http\Resources\V1\Core\FileCollection;
use App\Models\Core\File;
use App\Models\Core\Image;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Requirement;
use Illuminate\Support\Facades\Storage;

class RequirementController extends Controller
{
    function __construct()
    {
    }

    function catalogue(CatalogueRequirementRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $requirements = Requirement::customOrderBy($sorts)
            ->name($request->input('search'))
            ->limit(1000)
            ->get();

        return (new RequirementCollection($requirements))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function index(IndexRequirementRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $requirements = Requirement::customOrderBy($sorts)
            ->name($request->input('search'))
            ->paginate($request->input('perPage'));

        return (new RequirementCollection($requirements))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function show(Requirement $requirement)
    {
        return (new RequirementResource($requirement))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    public function store(StoreRequirementRequest $request)
    {
        $requirement = new Requirement();
        $requirement->state()->associate(Catalogue::find($request->input('state.id')));
        $requirement->name = $request->input('name');
        $requirement->required = $request->input('required');
        $requirement->save();

        return (new RequirementResource($requirement))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Creado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function update(UpdateRequirementRequest $request, Requirement $requirement)
    {
        $requirement->state()
            ->associate(Catalogue::find($request->input('state.id')));
        $requirement->name = $request->input('name');
        $requirement->required = $request->input('required');
        $requirement->save();

        return (new RequirementResource($requirement))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Actualizado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])->response()->setStatusCode(201);
    }

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
            ])->response()->setStatusCode(201);
    }

    public function destroys(DestroysRequirementRequest $request)
    {
        $requirement = Requirement::whereIn('id', $request->input('ids'))->get();

        Requirement::destroy($request->input('ids'));

        return (new RequirementCollection($requirement))
            ->additional([
                'msg' => [
                    'summary' => 'Periodos Eliminados',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    /*******************************************************************************************************************
     * FILES
     ******************************************************************************************************************/
    public function showFile(Requirement $Requirement, File $file)
    {
        return $Requirement->showFile($file);
    }

    /*******************************************************************************************************************
     * IMAGES
     ******************************************************************************************************************/
    public function showImage(Requirement $Requirement, Image $image)
    {
        return $Requirement->showImage($image);
    }

    public function downloadRequirement(Requirement $requirement)
    {
        $url = storage_path('app/private/registration-requirement/').$requirement->url;
        if (!Storage::exists($url)) {
            return (new FileCollection([]))->additional(
                [
                    'msg' => [
                        'summary' => 'Archivo no encontrado',
                        'detail' => 'Intente de nuevo',
                        'code' => '404'
                    ]
                ]);
        }
        return Storage::download($url);
    }
}

<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Institutions\DestroysInstitutionsRequest;
use App\Http\Requests\V1\Cecy\Institutions\IndexInstitutionsRequest;
use App\Http\Requests\V1\Cecy\Institutions\StoreInstitutionsRequest;
use App\Http\Requests\V1\Cecy\Institutions\UpdateInstitutionsRequest;
use App\Http\Resources\V1\Core\InstitutionCollection;
use App\Http\Resources\V1\Cecy\Institutions\InstitutionResource;
use App\Models\Cecy\Institution;


class InstitutionController extends Controller
{
    public function __construct()
    {
    }

    public function index(IndexInstitutionsRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $institution = Institution::customOrderBy($sorts)
            ->code($request->input('search'))
            ->name($request->input('search'))
            ->slogan($request->input('search'))
            ->paginate($request->input('per_page'));

        //return Institution::paginate();
        return (new InstitutionCollection(Institution::paginate()))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'Institution' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    
    public function show(Institution $institution)
    {
        return (new InstitutionResource($institution))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'Institution' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function store(StoreInstitutionsRequest $request)
    {
        $institution = new Institution();

        $institution->code = $request->input('code');
        $institution->name = $request->input('name');
        $institution->logo = $request->input('logo');
        $institution->slogan = $request->input('slogan');
        $institution->save();

        return (new InstitutionResource($institution))
            ->additional([
                'msg' => [
                    'summary' => 'Institución creada',
                    'Institution' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function update(UpdateInstitutionsRequest $request, Institution $institution)
    {
        $institution->code = $request->input('code');
        $institution->name = $request->input('name');
        $institution->logo = $request->input('logo');
        $institution->slogan = $request->input('slogan');
        $institution->save();
        return (new InstitutionResource($institution))
            ->additional([
                'msg' => [
                    'summary' => 'Institución actualizada',
                    'Institution' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function destroy(Institution $institution)
    {
        $institution->delete();

        return (new InstitutionResource($institution))
            ->additional([
                'msg' => [
                    'summary' => 'Institución eliminada',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function destroys(DestroysInstitutionsRequest $request)
    {
        $institution = Institution::whereIn('id', $request->input('ids'))->get();

        Institution::destroy($request->input('ids'));

        return (new InstitutionCollection($institution))
            ->additional([
                'msg' => [
                    'summary' => 'Instituciones eliminadas',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
}

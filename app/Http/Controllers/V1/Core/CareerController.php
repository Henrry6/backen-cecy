<?php

namespace App\Http\Controllers\V1\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Core\Careers\CatalogueCareerRequest;
use App\Http\Requests\V1\Core\Careers\GetCareersByCoordinatorCareerRequest;
use App\Http\Resources\V1\Core\CareerCollection;
use App\Http\Resources\V1\Core\CareerResource;
use App\Http\Resources\V1\Core\InstitutionCollection;
use App\Http\Resources\V1\Core\Users\UserResource;
use App\Models\Cecy\Authority;
use App\Models\Core\Career;

class CareerController extends Controller
{
    public function show(Career $career)
    {
        return (new CareerResource($career))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    function catalogue(CatalogueCareerRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));
        $careers = Career::customOrderBy($sorts)
            ->acronym($request->input('search'))
            ->description($request->input('search'))
            ->name($request->input('search'))
            ->resolutionNumber($request->input('search'))
            ->title($request->input('search'))
            ->limit(1000)
            ->get();

        return (new InstitutionCollection($careers))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function getCareersByCoordinatorCareer(GetCareersByCoordinatorCareerRequest $request)
    {
        $coordinator = $request->user()->authority()->first();

        // return $coordinator;

        // if () {
        //     return response()->json([
        //         'data' => '',
        //         'msg' => [
        //             'summary' => 'Error',
        //             'detail' => 'No eres coordinador de ninguna carrera',
        //             'code' => '400'
        //         ]
        //     ], 400);
        // }

        $careers = $coordinator->careers()->get();

        return (new CareerCollection($careers))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
}

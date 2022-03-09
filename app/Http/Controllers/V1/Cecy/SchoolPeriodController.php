<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\SchoolPeriods\DestroysSchoolPeriodRequest;
use App\Http\Requests\V1\Cecy\SchoolPeriods\StoreSchoolPeriodRequest;
use App\Http\Requests\V1\Cecy\SchoolPeriods\UpdateSchoolPeriodRequest;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodResource;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodCollection;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\SchoolPeriod;
use Illuminate\Support\Facades\Request;

class SchoolPeriodController extends Controller
{
    //Obtiene todas los periodos escolares que hay
    public function index(Request $request)
    {
        $schoolPeriods =  SchoolPeriod::get();
        return (new SchoolPeriodCollection($schoolPeriods))

            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    //Obtiene una periodo escolar
    public function show(SchoolPeriod $schoolPeriod)
    {
        return (new SchoolPeriodResource($schoolPeriod))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    //Crea una periodo escolar
    public function store(StoreSchoolPeriodRequest $request)
    {
        $schoolPeriod = new SchoolPeriod();
        $schoolPeriod->state()->associate(Catalogue::find($request->input('state.id')));
        $schoolPeriod->code = $request->input('code');
        $schoolPeriod->ended_at = $request->input('endedAt');
        $schoolPeriod->minimum_note = $request->input('minimumNote');
        $schoolPeriod->name = $request->input('name');
        $schoolPeriod->started_at = $request->input('startedAt');
        $schoolPeriod->save();

        return (new SchoolPeriodResource($schoolPeriod))
            ->additional([
                'msg' => [
                    'summary' => 'Periodo creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    //Actualiza un periodo escolar
    public function update (UpdateSchoolPeriodRequest $request, SchoolPeriod $schoolPeriod){

        $schoolPeriod->state()->associate(Catalogue::find($request->input('state.id')));
        $schoolPeriod->code = $request->input('code');
        $schoolPeriod->ended_at = $request->input('endedAt');
        $schoolPeriod->minium_note = $request->input('miniumNote');
        $schoolPeriod->name = $request->input('name');
        $schoolPeriod->started_at = $request->input('startedAt');
        $schoolPeriod->save();

        return (new SchoolPeriodResource($schoolPeriod))
        ->additional([
            'msg' => [
                'summary' => 'Periodo actualizado',
                'detail' => '',
                'code' => '200'
            ]
        ])
        ->response()->setStatusCode(201);
    }
    //Elimina un periodo escolar
    public function update(UpdateSchoolPeriodsRequest $request, SchoolPeriod $schooolperiod)
    {
        $schooolperiod->type()->associate(Catalogue::find($request->input('state.id')));
        $schooolperiod->code = $request->input('code');
        $schooolperiod->ended_at = $request->input('nded_at');
        $schooolperiod->minium_note = $request->input('minium_note');
        $schooolperiod->name = $request->input('name');
        $schooolperiod->started_at = $request->input('started_ad');
        $schooolperiod->save();

        return (new SchoolPeriodResource($schooolperiod))
            ->additional([
                'msg' => [
                    'summary' => 'Periodo actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    //Elimina un periodo escolar
    public function destroy(Request $request, SchoolPeriod $schoolPeriod)
    {
        $schoolPeriod->delete();

        return (new SchoolPeriodResource($schoolPeriod))
            ->additional([
                'msg' => [
                    'summary' => 'Periodo Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    //Elimina varias periodos escolares
    public function destroys(DestroysSchoolPeriodsRequest $request)
    {
        $schoolPeriod = SchoolPeriod::whereIn('id', $request->input('ids'))->get();

        SchoolPeriod::destroy($request->input('ids'));

        return (new SchoolPeriodCollection($schoolPeriod))
            ->additional([
                'msg' => [
                    'summary' => 'Periodos Eliminados',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
}

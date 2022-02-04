<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\DetailPlanifications\DestroysSchoolPeriodsRequest;
use App\Http\Requests\V1\Cecy\DetailPlanifications\StoreSchoolPeriodsRequest;
use App\Http\Requests\V1\Cecy\DetailPlanifications\UpdateSchoolPeriodsRequest;
use App\Http\Requests\V1\Cecy\SchoolPeriods\IndexSchoolPeriodsRequest;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodResource;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodsCollection;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\SchoolPeriod;
use Illuminate\Support\Facades\Request;

class ClassroomController extends Controller
{
    //Obtiene todas los periodos escolares que hay
    public function index(IndexSchoolPeriodsRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $schooolperiod = SchoolPeriod::customOrderBy($sorts)
            ->paginate($request->input('per_page'));

        return (new SchoolPeriodsCollection($schooolperiod))
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
    public function show(SchoolPeriod $schooolperiod)
    {
        return (new SchoolPeriodResource($schooolperiod))
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
    public function store(StoreSchoolPeriodsRequest $request)
    {        
        $schooolperiod = new SchoolPeriod();
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
                    'summary' => 'Periodo creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    //Actualiza un periodo escolar
    public function update (UpdateSchoolPeriodsRequest $request, SchoolPeriod $schooolperiod)
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
    public function destroy (Request $request, SchoolPeriod $schooolperiod)
    {
        
        $schooolperiod->delete();

        return (new SchoolPeriodResource($schooolperiod))
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
    public function destroys (DestroysSchoolPeriodsRequest $request)
    {
        $schooolperiod = SchoolPeriod::whereIn('id', $request->input('ids'))->get();

        SchoolPeriod::destroy($request->input('ids'));

        return (new SchoolPeriodsCollection($schooolperiod))
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

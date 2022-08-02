<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\SchoolPeriods\CatalogueSchoolPeriodRequest;
use App\Http\Requests\V1\Cecy\SchoolPeriods\DestroysSchoolPeriodRequest;
use App\Http\Requests\V1\Cecy\SchoolPeriods\StoreSchoolPeriodRequest;
use App\Http\Requests\V1\Cecy\SchoolPeriods\UpdateSchoolPeriodRequest;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodResource;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodCollection;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\SchoolPeriod;
use Illuminate\Http\Request;

class SchoolPeriodController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $schoolPeriods =  SchoolPeriod::customOrderBy($sorts)
            ->code($request->input('search'))
            ->name($request->input('search'))
            ->paginate($request->input('perPage'));

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

    public function show()
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

    public function getCurrent(SchoolPeriod $schoolPeriod)
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $currentState = Catalogue::firstWhere('code', $catalogue['school_period_state']['current']);
        $schoolPeriod = SchoolPeriod::firstWhere('state_id', $currentState->id);

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

    public function catalogue(CatalogueSchoolPeriodRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $schoolPeriods =  SchoolPeriod::customOrderBy($sorts)
            ->description($request->input('search'))
            ->limit(1000)
            ->get();

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
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function update(UpdateSchoolPeriodRequest $request, SchoolPeriod $schoolPeriod)
    {
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
                    'summary' => 'Periodo actualizado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

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

    public function destroys(DestroysSchoolPeriodRequest $request)
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

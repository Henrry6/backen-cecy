<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\DetailSchoolPeriods\DestroysDetailSchoolPeriodRequest;
use App\Http\Requests\V1\Cecy\DetailSchoolPeriods\IndexDetailSchoolPeriodRequest;
use App\Http\Requests\V1\Cecy\DetailSchoolPeriods\StoreDetailSchoolPeriodRequest;
use App\Http\Requests\V1\Cecy\DetailSchoolPeriods\UpdateDetailSchoolPeriodRequest;
use App\Http\Resources\V1\Cecy\DetailSchoolPeriods\DetailSchoolPeriodCollection;
use App\Http\Resources\V1\Cecy\DetailSchoolPeriods\DetailSchoolPeriodResource;
use App\Models\Cecy\DetailSchoolPeriod;
use Illuminate\Http\Request;

class DetailSchoolPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexDetailSchoolPeriodRequest $request)
    {
        $sorts = explode(',', $request->sort);
        $detailSchoolPeriods = DetailSchoolPeriod::customOrderBy($sorts)
            ->paginate($request->per_page);
        return (new DetailSchoolPeriodCollection($detailSchoolPeriods))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDetailSchoolPeriodRequest $request)
    {
        $detailSchoolPeriod = new DetailSchoolPeriod();

        $detailSchoolPeriod->schoolPeriod()
            ->associate(DetailSchoolPeriod::find($request->input('schoolPeriod.id')));

        $detailSchoolPeriod->especial_ended_at = $request->input('especialEndedAt');
        $detailSchoolPeriod->especial_started_at = $request->input('especialStartedAt');
        $detailSchoolPeriod->extraordinary_ended_at = $request->input('extraordinaryEndedAt');
        $detailSchoolPeriod->extraordinary_started_at = $request->input('extraordinaryStartedAt');
        $detailSchoolPeriod->nullification_started_at = $request->input('nullificationStartedAt');
        $detailSchoolPeriod->nullification_ended_at = $request->input('nullificationEndedAt');
        $detailSchoolPeriod->ordinary_ended_at = $request->input('ordinaryEndedAt');
        $detailSchoolPeriod->ordinary_started_at = $request->input('ordinaryStartedAt');

        $detailSchoolPeriod->save();

        return (new DetailSchoolPeriodResource($detailSchoolPeriod))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DetailSchoolPeriod $detailSchoolPeriod)
    {
        return (new DetailSchoolPeriodResource($detailSchoolPeriod))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetailSchoolPeriodRequest $request, DetailSchoolPeriod $detailSchoolPeriod)
    {
        $detailSchoolPeriod->schoolPeriod()
            ->associate(DetailSchoolPeriod::find($request->input('schoolPeriod.id')));

        $detailSchoolPeriod->especial_ended_at = $request->input('especialEndedAt');
        $detailSchoolPeriod->especial_started_at = $request->input('especialStartedAt');
        $detailSchoolPeriod->extraordinary_ended_at = $request->input('extraordinaryEndedAt');
        $detailSchoolPeriod->extraordinary_started_at = $request->input('extraordinaryStartedAt');
        $detailSchoolPeriod->nullification_started_at = $request->input('nullificationStartedAt');
        $detailSchoolPeriod->nullification_ended_at = $request->input('nullificationEndedAt');
        $detailSchoolPeriod->ordinary_ended_at = $request->input('ordinaryEndedAt');
        $detailSchoolPeriod->ordinary_started_at = $request->input('ordinaryStartedAt');

        $detailSchoolPeriod->save();

        return (new DetailSchoolPeriodResource($detailSchoolPeriod))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailSchoolPeriod $detailSchoolPeriod)
    {
        $detailSchoolPeriod->delete();
        return (new DetailSchoolPeriodResource($detailSchoolPeriod))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    public function destroys (DestroysDetailSchoolPeriodRequest $request)
    {
        $schoolPeriod = DetailSchoolPeriod::whereIn('id', $request->input('ids'))->get();

        DetailSchoolPeriod::destroy($request->input('ids'));

        return (new DetailSchoolPeriodCollection($schoolPeriod))
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

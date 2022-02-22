<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\DetailSchoolPeriods\IndexDetailSchoolPeriodsRequest;
use App\Http\Requests\V1\Cecy\DetailSchoolPeriods\StoreDetailSchoolPeriodsRequest;
use App\Http\Requests\V1\Cecy\DetailSchoolPeriods\UpdateDetailSchoolPeriodsRequest;
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
    public function index(IndexDetailSchoolPeriodsRequest $request)
    {
        return "detail school periods";
        $sorts = explode(',', $request->sort);
        $detailSchoolPeriods = DetailSchoolPeriod::customOrderBy($sorts)
            ->especialEndedAt($request->input('especial_ended_at'))
            ->especialStartedAt($request->input('especial_started_at'))
            ->extraordinaryEndedAt($request->input('extraordinary_ended_at'))
            ->extraordinaryStartedAt($request->input('extraordinary_started_at'))
            ->nullificationStartedAt($request->input('nullification_started_at'))
            ->nullificationEndedAt($request->input('nullification_ended_at'))
            ->ordinaryEndedAt($request->input('ordinary_ended_at'))
            ->ordinaryStartedAt($request->input('ordinary_started_at'))
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
    public function store(StoreDetailSchoolPeriodsRequest $request)
    {
        $detailSchoolPeriod = new DetailSchoolPeriod();

        $detailSchoolPeriod->schoolPeriod()
            ->associate(DetailSchoolPeriod::find($request->input('detail_school_period.id')));

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
    public function update(UpdateDetailSchoolPeriodsRequest $request, DetailSchoolPeriod $detailSchoolPeriod)
    {
        $detailSchoolPeriod->schoolPeriod()
            ->associate(DetailSchoolPeriod::find($request->input('detail_school_period.id')));

        $detailSchoolPeriod->especial_ended_at = $request->input('especialEndedAt');
        $detailSchoolPeriod->especial_started_at = $request->input('especialStartedAt');
        $detailSchoolPeriod->extraordinary_ended_at = $request->input('extraordinaryEndedAt');
        $detailSchoolPeriod->extraordinary_started_at = $request->input('extraordinaryStartedAt');
        $detailSchoolPeriod->nullification_started_at = $request->input('nullificationStartedAt');
        $detailSchoolPeriod->nullification_ended_at = $request->input('nullificationEndedAt');
        $detailSchoolPeriod->ordinary_ended_at = $request->input('ordinaryEndedAt');
        $detailSchoolPeriod->ordinary_started_at = $request->input('ordinaryStartedAt');

        $detailSchoolPeriod->save();
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
}

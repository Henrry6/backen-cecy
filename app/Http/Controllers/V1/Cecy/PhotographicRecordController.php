<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\PhotographicRecords\DestroyPhotographicRecordRequest;
use App\Http\Requests\V1\Cecy\PhotographicRecords\StorePhotographicRecordRequest;
use App\Http\Requests\V1\Cecy\PhotographicRecords\UpdatePhotographicRecordRequest;
use App\Http\Requests\V1\Core\Files\DestroysFileRequest;
use App\Http\Requests\V1\Core\Files\IndexFileRequest;
use App\Http\Requests\V1\Core\Files\UpdateFileRequest;
use App\Http\Requests\V1\Core\Files\UploadFileRequest;
use App\Http\Resources\V1\Cecy\PhotographicRecords\PhotographicRecordCollection;
use App\Http\Resources\V1\Cecy\PhotographicRecords\PhotographicRecordResource;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\PhotographicRecord;
use App\Models\Core\File;

class PhotographicRecordController extends Controller
{
    public function index()
    {
        return (new PhotographicRecordCollection(PhotographicRecord::paginate()))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'institution' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    public function show(PhotographicRecord $photographicRecord)
    {
        return (new PhotographicRecordResource($photographicRecord))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'institution' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function store(StorePhotographicRecordRequest $request)
    {
        $photographicRecord = new PhotographicRecord();
        $photographicRecord->detailPlanification()
            ->associate(DetailPlanification::find($request->input('detail_planification.id')));

        $photographicRecord->description = $request->input('description');
        $photographicRecord->number_week = $request->input('number_week');
        $photographicRecord->url_image = $request->input('url_image');
        $photographicRecord->week_at = $request->input('week_at');

        $photographicRecord->save();

        return (new PhotographicRecordResource($photographicRecord))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Fotográfico Creado',
                    'institution' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function update(UpdatePhotographicRecordRequest $request, PhotographicRecord $photographicRecord)
    {
        $photographicRecord->detailPlanification()
            ->associate(DetailPlanification::find($request->input('detail_planification.id')));

        $photographicRecord->description = $request->input('description');
        $photographicRecord->number_week = $request->input('number_week');
//        $photographicRecord->url_image = $request->input('url_image');
        $photographicRecord->week_at = $request->input('week_at');

        $photographicRecord->save();

        return (new PhotographicRecordResource($photographicRecord))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Fotográfico Creado',
                    'institution' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function destroy(PhotographicRecord $photographicRecord)
    {
        $photographicRecord->delete();
        return (new PhotographicRecordResource($photographicRecord))
            ->additional([
                'msg' => [
                    'summary' => 'Registro Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function destroys(DestroyPhotographicRecordRequest $request)
    {
        $photographicRecord = PhotographicRecord::whereIn('id', $request->input('ids'))->get();

        PhotographicRecord::destroy($request->input('ids'));

        return (new PhotographicRecordCollection($photographicRecord))
            ->additional([
                'msg' => [
                    'summary' => 'instituciones Eliminadas',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    //revisar
    public function getPhotograficRecord(DetailPlanification $detailPlanification){
        $photographicRecords = $detailPlanification->photographicRecords()->get();
        return(new PhotographicRecordCollection($photographicRecords))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'records' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    /*******************************************************************************************************************
     * FILES
     ******************************************************************************************************************/
    public function indexFiles(IndexFileRequest $request, PhotographicRecord $record)
    {
        return $record->indexFiles($request);
    }

    public function uploadFile(UploadFileRequest $request, PhotographicRecord $record)
    {
        return $record->uploadFile($request);
    }

    public function downloadFile(PhotographicRecord $record, File $file)
    {
        return $record->downloadFile($file);
    }

    public function downloadFiles(PhotographicRecord $record)
    {
        return $record->downloadFiles();
    }

    public function showFile(PhotographicRecord $record, File $file)
    {
        return $record->showFile($file);
    }

    public function updateFile(UpdateFileRequest $request, PhotographicRecord $record, File $file)
    {
        return $record->updateFile($request, $file);
    }

    public function destroyFile(PhotographicRecord $record, File $file)
    {
        return $record->destroyFile($file);
    }

    public function destroyFiles(PhotographicRecord $record, DestroysFileRequest $request)
    {
        return $record->destroyFiles($request);
    }
}

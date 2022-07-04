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
use App\Http\Requests\V1\Core\Images\IndexImageRequest;
use App\Http\Requests\V1\Core\Images\UploadImageRequest;
use App\Http\Resources\V1\Cecy\PhotographicRecords\PhotographicRecordCollection;
use App\Http\Resources\V1\Cecy\PhotographicRecords\PhotographicRecordResource;
use App\Http\Resources\V1\Core\ImageResource;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\PhotographicRecord;
use App\Models\Core\File;
use App\Models\Core\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

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
     * imagenes
     ******************************************************************************************************************/

    //Images
    public function uploadImage(UploadImageRequest $request, PhotographicRecord $record)
    {
        $images = $record->images()->get();
        foreach ($images as $image) {
            // Storage::deleteDirectory($image->directory);
            Storage::disk('public')->deleteDirectory('records' . $image->id);
            $image->delete();
        }

        foreach ($request->file('images') as $image) {
            $newImage = new Image();
            $newImage->name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $newImage->description = $request->input('description');
            $newImage->extension = 'jpg';
            $newImage->imageable()->associate($record);
            $newImage->save();


            Storage::disk('public')->makeDirectory('records/' . $newImage->id);

            $storagePath = storage_path('app/public/records/');
            $record->uploadOriginal(InterventionImage::make($image), $newImage->id, $storagePath);
            $record->uploadLargeImage(InterventionImage::make($image), $newImage->id, $storagePath);
            $record->uploadMediumImage(InterventionImage::make($image), $newImage->id, $storagePath);
            $record->uploadSmallImage(InterventionImage::make($image), $newImage->id, $storagePath);

            $newImage->directory = 'images/' . $newImage->id;
            $newImage->save();
        }
        return (new ImageResource($newImage))->additional(
            [
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]
        );
    }

    public function indexPublicImages(IndexImageRequest $request, PhotographicRecord $record)
    {
        return $record->indexPublicImages($request);
    }
}

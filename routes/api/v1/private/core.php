<?php

use App\Models\Cecy\PhotographicRecord;
use App\Models\Core\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Core\InstitutionController;
use App\Http\Controllers\V1\Core\UserController;
use App\Http\Controllers\V1\Core\FileController;
use App\Http\Controllers\V1\Core\CareerController;
use App\Http\Controllers\V1\Core\CatalogueController;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

/***********************************************************************************************************************
 * USERS
 **********************************************************************************************************************/
Route::prefix('user')->group(function () {
    Route::patch('catalogue', [UserController::class, 'catalogue']);
    Route::patch('destroys', [UserController::class, 'destroys']);
});

Route::prefix('users/{user}')->group(function () {
    Route::prefix('files')->group(function () {
        Route::get('{file}/download', [UserController::class, 'downloadFile']);
        Route::get('', [UserController::class, 'indexFiles']);
        Route::get('{file}', [UserController::class, 'showFile']);
        Route::post('', [UserController::class, 'uploadFile']);
        Route::put('{file}', [UserController::class, 'updateFile']);
        Route::delete('{file}', [UserController::class, 'destroyFile']);
        Route::patch('', [UserController::class, 'destroyFiles']);
    });
    Route::prefix('images')->group(function () {
        Route::get('{image}/download', [UserController::class, 'downloadImage']);
        Route::get('', [UserController::class, 'indexImages']);
        Route::get('public', [UserController::class, 'indexPublicImages']);
        Route::get('{image}', [UserController::class, 'showImage']);
        Route::post('public', [UserController::class, 'uploadPublicImage']);
        Route::put('{image}', [UserController::class, 'updateImage']);
        Route::delete('{image}', [UserController::class, 'destroyImage']);
        Route::patch('', [UserController::class, 'destroyImages']);
    });
});
Route::apiResource('users', UserController::class);

/***********************************************************************************************************************
 * INSTITUTIONS
 **********************************************************************************************************************/
Route::apiResource('institutions', InstitutionController::class);

Route::prefix('institution')->group(function () {
    Route::get('catalogue', [InstitutionController::class, 'catalogue']);
});

Route::prefix('institution/{institution}')->group(function () {
    Route::get('careers', [InstitutionController::class, 'careers']);
});

/***********************************************************************************************************************
 * CAREERS
 **********************************************************************************************************************/
Route::apiResource('careers', CareerController::class);

Route::prefix('career')->group(function () {
    Route::get('catalogue', [CareerController::class, 'catalogue']);
});


/***********************************************************************************************************************
 * FILES
 **********************************************************************************************************************/
Route::prefix('files')->group(function () {
    Route::patch('destroys', [FileController::class, 'destroys']);
});

Route::prefix('files/{file}')->group(function () {
    Route::get('download', [FileController::class, 'download']);
});

Route::apiResource('files', FileController::class)->except(['index', 'store']);

/***********************************************************************************************************************
 * CATALOGUE
 **********************************************************************************************************************/
Route::apiResource('core-catalogue/catalogue', CatalogueController::class);

Route::post('test-url-image', function (Request $request) {
    try {
        Storage::disk('private')->makeDirectory('other-images');
        $image = $request->file('image');
        $storagePath = storage_path('app/private/other-images/');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $path = $storagePath . $name;
        $image = InterventionImage::make($image);
        $image->save($path, 75);

        $photographicRecord = new PhotographicRecord();
        $photographicRecord->detailPlanification()->associate(\App\Models\Cecy\DetailPlanification::find(1));
        $photographicRecord->number_week = $request->input('numberWeek');
        $photographicRecord->description = $request->input('description');
        $photographicRecord->week_at = $request->input('weekAt');
        $photographicRecord->url_image = 'other-images/' . $name;
        $photographicRecord->save();
    } catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $e) {
        return response()->json([
            'msg' => [
                'summary' => 'error',
                'detail' => 'error',
                'code' => '500',
            ]
        ], 500);
    }

});

Route::post('test-url-file', function (Request $request) {
    try {
        Storage::disk('private')->makeDirectory('other-files');
        $file = $request->file('file');
        $name = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('other-files', $name, 'private');

        $photographicRecord = new PhotographicRecord();
        $photographicRecord->detailPlanification()->associate(\App\Models\Cecy\DetailPlanification::find(1));
        $photographicRecord->number_week = $request->input('numberWeek');
        $photographicRecord->description = $request->input('description');
        $photographicRecord->week_at = $request->input('weekAt');
        $photographicRecord->url_image = 'other-files/' . $name;
        $photographicRecord->save();
    } catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $e) {
        return response()->json([
            'msg' => [
                'summary' => 'error',
                'detail' => 'error',
                'code' => '500',
            ]
        ], 500);
    }

});

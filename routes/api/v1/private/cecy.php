<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Cecy\CatalogueController;
use App\Http\Controllers\V1\Cecy\GuachagmiraController;
use App\Http\Controllers\V1\Cecy\GuanunaController;
use App\Http\Controllers\V1\Cecy\PerezController;
use App\Http\Controllers\V1\Cecy\CourseController;
use App\Http\Controllers\V1\Cecy\TopicController;
use App\Http\Controllers\V1\Cecy\PrerequisiteController;

/***********************************************************************************************************************
 * CATALOGUES
 **********************************************************************************************************************/
Route::apiResource('catalogues', CatalogueController::class);

Route::prefix('catalogue/{catalogue}')->group(function () {
    Route::prefix('file')->group(function () {
        Route::get('{file}/download', [CatalogueController::class, 'downloadFile']);
        Route::get('download', [CatalogueController::class, 'downloadFiles']);
        Route::get('', [CatalogueController::class, 'indexFiles']);
        Route::get('{file}', [CatalogueController::class, 'showFile']);
        Route::post('', [CatalogueController::class, 'uploadFile']);
        Route::post('{file}', [CatalogueController::class, 'updateFile']);
        Route::delete('{file}', [CatalogueController::class, 'destroyFile']);
        Route::patch('', [CatalogueController::class, 'destroyFiles']);
    });
    Route::prefix('image')->group(function () {
        Route::get('{image}/download', [CatalogueController::class, 'downloadImage'])->withoutMiddleware('auth:sanctum');
        Route::get('', [CatalogueController::class, 'indexImages']);
        Route::get('{image}', [CatalogueController::class, 'showImage']);
        Route::post('', [CatalogueController::class, 'uploadImage']);
        Route::post('{image}', [CatalogueController::class, 'updateImage']);
        Route::delete('{image}', [CatalogueController::class, 'destroyImage']);
        Route::patch('', [CatalogueController::class, 'destroyImages']);
    });
});

/***********************************************************************************************************************
 * INSTITUTIONS
 **********************************************************************************************************************/

/***********************************************************************************************************************
 * PLANIFICATIONS
 **********************************************************************************************************************/
Route::prefix('planification')->group(function () {
    Route::get('course/{course}', [PerezController::class, 'getPlanificationsByCourse']);
    Route::get('state/{state}', [PerezController::class, 'getKpi']);
});

Route::prefix('planification/{planification}')->group(function () {
    Route::put('', [PerezController::class, 'updateDatesAndNeedsInPlanification']);
});

/***********************************************************************************************************************
 * DETAIL PLANIFICATIONS
 **********************************************************************************************************************/
Route::prefix('detailPlanification')->group(function () {
    Route::get('', [PerezController::class, 'getDetailPlanificationsByPlanification']);
    Route::post('', [PerezController::class, 'registerDetailPlanification']);
    Route::patch('', [PerezController::class, 'destroysDetailPlanifications']);
});

Route::prefix('detailPlanification/{detailPlanification}')->group(function () {
    Route::get('', [PerezController::class, 'showDetailPlanification']);
    Route::put('', [PerezController::class, 'updateDetailPlanification']);
    Route::delete('', [PerezController::class, 'deleteDetailPlanification']);
});

/***********************************************************************************************************************
 * COURSE
 **********************************************************************************************************************/
Route::prefix('courses')->group(function () {
    Route::get('', [CourseController::class, 'getCourses']);
    Route::put('/{course}', [CourseController::class, 'updateCourse']);
});

/***********************************************************************************************************************
 * TOPICS
 **********************************************************************************************************************/
Route::prefix('topics')->group(function () {
    Route::get('/{course}', [TopicController::class, 'getTopics']);
    Route::post('/{course}', [TopicController::class, 'storeTopic']);
    Route::put('/{course}', [TopicController::class, 'updateTopic']);
    Route::delete('', [TopicController::class, 'destroyTopic']);
    Route::patch('', [TopicController::class, 'destroysTopics']);
});

/***********************************************************************************************************************
 * PREREQUISITES
 **********************************************************************************************************************/
Route::prefix('prerequisite')->group(function () {
    Route::get('/{course}', [PrerequisiteController::class, 'getPrerequisites']);
    Route::post('/{course}', [PrerequisiteController::class, 'storePrerequisite']);
    Route::put('/{course}', [PrerequisiteController::class, 'updatePrerequisite']);
    Route::delete('', [PrerequisiteController::class, 'DestroyPrerequisite']);
    Route::patch('', [PrerequisiteController::class, 'destroysPrerequisites']);
});

/***********************************************************************************************************************
 * USERS
 **********************************************************************************************************************/
Route::prefix('user')->group(function () {
    Route::get('course/{course}', [GuachagmiraController::class, 'getInstructorsInformationByCourse']);
});

Route::prefix('detailPlanification')->group(function () {
    Route::get('course/{course}', [GuachagmiraController::class, 'getDetailPlanificationsByCourse']);
});

<?php

use App\Http\Controllers\V1\Core\CatalogueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Core\LocationController;

/***********************************************************************************************************************
 * LOCATIONS
 **********************************************************************************************************************/
Route::controller(LocationController::class)->group(function () {
    Route::prefix('locations/{location}')->group(function () {
    });

    Route::prefix('locations')->group(function () {
        Route::get('catalogue', 'catalogue');
        
    });
});
 Route::apiResource('locations', LocationController::class);

/***********************************************************************************************************************
 * CATALOGUES
 **********************************************************************************************************************/
Route::prefix('core-catalogue')->group(function () {
    Route::get('catalogue', [CatalogueController::class, 'catalogue']);
});

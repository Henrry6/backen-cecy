<?php

use App\Http\Controllers\V1\Core\CatalogueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Core\LocationController;

/***********************************************************************************************************************
 * LOCATIONS
 **********************************************************************************************************************/
Route::apiResource('locations', LocationController::class);

/***********************************************************************************************************************
 * CATALOGUES
 **********************************************************************************************************************/
Route::prefix('core-catalogue')->group(function () {
    Route::get('catalogue', [CatalogueController::class, 'catalogue']);
});

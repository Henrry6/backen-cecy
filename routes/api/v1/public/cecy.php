<?php

use App\Http\Controllers\V1\Cecy\ParticipantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Core\CatalogueController;

/***********************************************************************************************************************
 * CATALOGUES
 **********************************************************************************************************************/
Route::prefix('cecy-catalogue')->group(function () {
    Route::get('catalogue', [CatalogueController::class, 'catalogue']);
});

Route::prefix('user')->group(function () {
    Route::post('registration', [ParticipantController::class, 'registerUserParticipant']);
});

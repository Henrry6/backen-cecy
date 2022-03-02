<?php

use App\Http\Controllers\V1\Cecy\CatalogueController;
use App\Http\Controllers\V1\Cecy\CourseController;
use App\Http\Controllers\V1\Cecy\ParticipantController;
use Illuminate\Support\Facades\Route;

/***********************************************************************************************************************
 * CATALOGUES
 **********************************************************************************************************************/
Route::prefix('cecy-catalogue')->group(function () {
    Route::get('catalogue', [CatalogueController::class, 'catalogue']);
});

Route::prefix('participant-user')->group(function () {
    Route::post('registration', [ParticipantController::class, 'registerParticipantUser']);
});

Route::prefix('courses-guest')->group(function () {
    Route::get('public-courses', [CourseController::class, 'getPublicCourses']);
    Route::get('public-courses-category/{category}', [CourseController::class, 'getPublicCoursesByCategory']);
});

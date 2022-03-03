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

/***********************************************************************************************************************
 * USERS/PARTICIPANT
 **********************************************************************************************************************/
Route::prefix('participant-user')->group(function () {
    Route::post('registration', [ParticipantController::class, 'registerParticipantUser']);
});

/***********************************************************************************************************************
 * COURSES
 **********************************************************************************************************************/
Route::prefix('courses-guest')->group(function () {
    Route::get('public-courses', [CourseController::class, 'getPublicCourses']);
    Route::get('public-courses-category/{category}', [CourseController::class, 'getPublicCoursesByCategory']);
});

Route::prefix('courses-guest/{course}')->group(function () {
    Route::prefix('image')->group(function () {
        Route::get('{image}', [CourseController::class, 'showImageCourse']);
        Route::post('', [CourseController::class, 'uploadImageCourse']);
    });
});

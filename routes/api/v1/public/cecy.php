<?php

use App\Http\Controllers\V1\Cecy\CatalogueController;
use App\Http\Controllers\V1\Cecy\CourseController;
use App\Http\Controllers\V1\Cecy\ParticipantController;
use App\Http\Controllers\V1\Cecy\PrerequisiteController;
use App\Http\Controllers\V1\Cecy\TopicController;
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
    Route::post('registration', [ParticipantController::class, 'registerParticipantUser']);//Guachagmira
});

/***********************************************************************************************************************
 * COURSES
 **********************************************************************************************************************/
Route::prefix('courses-guest')->group(function () {
    Route::get('public-courses', [CourseController::class, 'getPublicCourses']);//Guachagmira
    Route::get('public-courses-category/{category}', [CourseController::class, 'getPublicCoursesByCategory']);//Guachagmira
});
Route::prefix('courses-guest/{course}')->group(function () {
    Route::prefix('')->group(function () {
        Route::get('/topics', [TopicController::class, 'getTopics']);//Guachagmira
    });
    Route::prefix('')->group(function () {
        Route::get('/prerequisites', [PrerequisiteController::class, 'getPrerequisites']);//Guachagmira
    });
});

Route::prefix('courses-guest/{course}')->group(function () {
    Route::prefix('image')->group(function () {
        Route::get('{image}', [CourseController::class, 'showImageCourse']);
        Route::post('', [CourseController::class, 'uploadImageCourse']);
    });
});

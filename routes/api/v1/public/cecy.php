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
    Route::prefix('')->group(function () {
        Route::get('/topics', [TopicController::class, 'getTopics']);
        Route::get('/topics/all', [TopicController::class, 'getAllTopics']);
        Route::post('/topics', [TopicController::class, 'storesTopics']);
        Route::put('/topics', [TopicController::class, 'updateTopics']);
        Route::delete('/topics/{topic}', [TopicController::class, 'destroyTopic']);
        Route::get('/topics/{topic}', [TopicController::class, 'show']);
        Route::get('/instructors', [TopicController::class, 'getInstructors']);
    });
    Route::prefix('')->group(function () {
        Route::get('/prerequisites/all', [PrerequisiteController::class, 'getPrerequisitesAll']);
        Route::get('/prerequisites', [PrerequisiteController::class, 'getPrerequisites']);
        Route::post('/prerequisites', [PrerequisiteController::class, 'storePrerequisite']);
        Route::put('/prerequisites/{prerequisite}', [PrerequisiteController::class, 'updatePrerequisite']);
        Route::delete('/prerequisites/{prerequisite}', [PrerequisiteController::class, 'destroyPrerequisite']);
        Route::patch('/prerequisites/destroys', [PrerequisiteController::class, 'destroysPrerequisites']);
    });
});

Route::prefix('courses-guest/{course}')->group(function () {
    Route::prefix('image')->group(function () {
        Route::get('{image}', [CourseController::class, 'showImageCourse']);
        Route::post('', [CourseController::class, 'uploadImageCourse']);
    });
});

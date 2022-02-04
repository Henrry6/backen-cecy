<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Cecy\CatalogueController;
use App\Http\Controllers\V1\Cecy\GuachagmiraController;
use App\Http\Controllers\V1\Cecy\GuanunaController;
use App\Http\Controllers\V1\Cecy\PerezController;
use App\Http\Controllers\V1\Cecy\CourseController;
use App\Http\Controllers\V1\Cecy\DetailAttendanceController;
use App\Http\Controllers\V1\Cecy\TopicController;
use App\Http\Controllers\V1\Cecy\PrerequisiteController;
use App\Http\Controllers\V1\Cecy\PlanificationController;

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

    Route::get('planifications',[PlanificationController::class,'getPlanitifications']);
    Route::get('planfications-course/{course}', [PlanificationController::class, 'getPlanificationsByCourse']);
    Route::get('kpis/{state}', [PlanificationController::class, 'getKpi']);
    // tambien podria ser user/{users}/planification
    Route::get('planifications-period-state',[PlanificationController::class, 'getPlanificationsByPeriodState']);
    Route::get('course_parallels-works',[PlanificationController::class, 'getCoursesParallelsWorkdays']);
});

Route::prefix('planification/{planification}')->group(function () {
    Route::put('dates-and-needs-planifications', [PlanificationController::class, 'updateDatesAndNeedsInPlanification']);
    Route::post('create-planifications-course',[PlanificationController::class, 'storePlanificationByCourse']);
    Route::put('planifications-cecy',[PlanificationController::class, 'updatePlanificationByCecy']);
    Route::put('assign-code-planification',[PlanificationController::class, 'assignCodeToPlanification']);
    Route::put('approve-planification',[PlanificationController::class, 'approvePlanification']);
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
 * TOPICS
 **********************************************************************************************************************/
Route::prefix('topics')->group(function () {
    Route::get('/{course}', [TopicController::class, 'getTopics']);
    Route::post('/{course}', [TopicController::class, 'storeTopic']);
    Route::put('/{course}/{topic}', [TopicController::class, 'updateTopic']);
    Route::delete('/{topic}', [TopicController::class, 'destroyTopic']);
    Route::patch('', [TopicController::class, 'destroysTopics']);
});

/***********************************************************************************************************************
 * PREREQUISITES
 **********************************************************************************************************************/
Route::prefix('prerequisites')->group(function () {
    Route::get('/{course}', [PrerequisiteController::class, 'getPrerequisites']);
    Route::post('/{course}', [PrerequisiteController::class, 'storePrerequisite']);
    Route::put('/{course}/{prerequisite}', [PrerequisiteController::class, 'updatePrerequisite']);
    Route::delete('/{prerequisite}', [PrerequisiteController::class, 'DestroyPrerequisite']);
    Route::patch('', [PrerequisiteController::class, 'destroysPrerequisites']);
});

/***********************************************************************************************************************
 * COURSE
 **********************************************************************************************************************/
Route::prefix('course')->group(function () {
    Route::patch('{course}', [CourseController::class, 'updateCourse']);
    Route::get('public', [CourseController::class, 'getPublicCourses']);
    Route::get('', [CourseController::class, 'getPublicCoursesByCategory']);
    Route::get('', [CourseController::class, 'getPublicCoursesByName']);
    Route::get('', [CourseController::class, 'getPrivateCoursesByParticipantType']);
    Route::get('', [CourseController::class, 'getPrivateCoursesByCategory']);
    Route::get('', [CourseController::class, 'getPrivateCoursesByName']);
    Route::get('', [CourseController::class, 'getCoursesByResponsibleCourse']);
    Route::get('', [CourseController::class, '']);
    Route::patch('{course}', [CourseController::class, 'updateGeneralInformationCourse']);
    Route::get('', [CourseController::class, 'getCoursesByCoordinator']);
    Route::get('', [CourseController::class, 'getCoursesKPI']);
    Route::patch('', [CourseController::class, 'assignCodeToCourse']);
    Route::patch('{course}', [CourseController::class, 'approveCourse']);
    Route::get('{course}', [CourseController::class, 'showInformCourseNeeds']);
    Route::get('', [CourseController::class, 'showYearSchedule']);
    Route::get('{course}', [CourseController::class, 'showCurricularDesign']);
    Route::get('{course}', [CourseController::class, 'showFinalCourseReport']);
    Route::get('{career}', [CourseController::class, 'getCoursesByInstructor']);
    Route::post('{course}', [CourseController::class, 'storeCourseNew']);
});

Route::prefix('courses')->group(function () {
    Route::get('', [CourseController::class, 'getCourses']);
    Route::get('', [CourseController::class, 'getCoursesByInstructor']);
});

/***********************************************************************************************************************
 * DETAIL ATTENDANCES
 **********************************************************************************************************************/

Route::prefix('detailAttendance')->group(function () {
    Route::get('course/{course}', [DetailAttendanceController::class, 'showAttedanceParticipant']);
    Route::patch('/{detailAttendance}',[DetailAttendanceController::class,'updatDetailAttendanceTeacher']);
});


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Cecy\CatalogueController;
use App\Http\Controllers\V1\Cecy\ClassroomController;
use App\Http\Controllers\V1\Cecy\GuachagmiraController;
use App\Http\Controllers\V1\Cecy\GuanunaController;
use App\Http\Controllers\V1\Cecy\PerezController;
use App\Http\Controllers\V1\Cecy\CourseController;
use App\Http\Controllers\V1\Cecy\DetailAttendanceController;
use App\Http\Controllers\V1\Cecy\InstitutionController;
use App\Http\Controllers\V1\Cecy\TopicController;
use App\Http\Controllers\V1\Cecy\PrerequisiteController;
use App\Http\Controllers\V1\Cecy\PlanificationController;
use App\Http\Controllers\V1\Cecy\SchoolPeriodController;
use App\Http\Controllers\V1\Cecy\InstructorController;


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

Route::apiResource('institutions', InstitutionController::class);


Route::prefix('institution')->group(function () {
    Route::patch('{institution}', [InstitutionController::class, 'destroys']);
});

/***********************************************************************************************************************
 * PLANIFICATIONS
 **********************************************************************************************************************/
//Route::apiResource('planifications',[PlanificationController::class]);

Route::prefix('planification')->group(function () {
    Route::get('{course}', [PlanificationController::class, 'getPlanificationsByCourse']);
    Route::get('planfications-course/{course}', [PlanificationController::class, 'getPlanificationsByCourse']);
    Route::get('kpis/{state}', [PlanificationController::class, 'getKpi']);
    Route::get('planifications-period-state', [PlanificationController::class, 'getPlanificationsByPeriodState']);
    Route::get('course_parallels-works', [PlanificationController::class, 'getCoursesParallelsWorkdays']);
});

Route::prefix('planification/{planification}')->group(function () {
    Route::put('dates-and-needs-planifications', [PlanificationController::class, 'updateDatesAndNeedsInPlanification']);
    Route::post('create-planifications-course', [PlanificationController::class, 'storePlanificationByCourse']);
    Route::put('planifications-cecy', [PlanificationController::class, 'updatePlanificationByCecy']);
    Route::put('assign-code-planification', [PlanificationController::class, 'assignCodeToPlanification']);
    Route::put('approve-planification', [PlanificationController::class, 'approvePlanification']);
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
    Route::get('{course}', [TopicController::class, 'getTopics']);
    Route::post('{course}', [TopicController::class, 'storeTopic']);
    Route::put('{course}/{topic}', [TopicController::class, 'updateTopic']);
    Route::delete('{topic}', [TopicController::class, 'destroyTopic']);
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
    Route::patch('{course}', [CourseController::class, 'updateGeneralInformationCourse']);
    Route::patch('{course}', [CourseController::class, 'assignCodeToCourse']);
    Route::patch('{course}', [CourseController::class, 'approveCourse']);
    Route::get('{course}', [CourseController::class, 'showInformCourseNeeds']);
    Route::get('{course}', [CourseController::class, 'showCurricularDesign']);
    Route::get('{course}', [CourseController::class, 'showFinalCourseReport']);
    Route::get('{career}', [CourseController::class, 'getCoursesByCareer']);
    Route::post('{course}', [CourseController::class, 'storeCourseNew']);
});

Route::prefix('courses')->group(function () {
    Route::get('', [CourseController::class, 'getCourses']);
    Route::get('public-courses', [CourseController::class, 'getPublicCourses']);
    Route::get('public-courses-category', [CourseController::class, 'getPublicCoursesByCategory']);
    Route::get('public-courses-name', [CourseController::class, 'getPublicCoursesByName']);
    Route::get('private-courses-participant', [CourseController::class, 'getPrivateCoursesByParticipantType']);
    Route::get('private-courses-category', [CourseController::class, 'getPrivateCoursesByCategory']);
    Route::get('private-courses-name', [CourseController::class, 'getPrivateCoursesByName']);
    Route::get('courses-responsible', [CourseController::class, 'getCoursesByResponsibleCourse']);
    Route::get('courses-instructor', [CourseController::class, 'getCoursesByInstructor']);
    Route::get('courses-coodinator', [CourseController::class, 'getCoursesByCoordinator']);
    Route::get('courses-kpi', [CourseController::class, 'getCoursesKPI']);
    Route::get('year-schedule', [CourseController::class, 'showYearSchedule']);
});

/***********************************************************************************************************************
 * DETAIL ATTENDANCES
 **********************************************************************************************************************/

Route::prefix('detailAttendance')->group(function () {
    Route::get('course/{course}', [DetailAttendanceController::class, 'showAttedanceParticipant']);
    Route::patch('/{detailAttendance}', [DetailAttendanceController::class, 'updatDetailAttendanceTeacher']);
});

/***********************************************************************************************************************
 * CERTIFICATES
 **********************************************************************************************************************/
Route::prefix('certificate')->group(function () {
    Route::get('catalogue/{catalogue}/file/{file}', [CertificateController::class, 'downloadFileCertificates']);
    Route::get('registration/{registration}/catalogue/{catalogue}/file/{file}', [CertificateController::class, 'downloadFileCertificates']);
    Route::post('catalogue/{catalogue}', [CertificateController::class, 'uploadFileCertificate']);
    Route::post('firm/catalogue/{catalogue}', [CertificateController::class, 'uploadFileCertificateFirm']);
});
/***********************************************************************************************************************
 * SCHOOL PERIODS
 **********************************************************************************************************************/

Route::apiResource('schoolperiods', SchoolPeriodController::class);

Route::prefix('schoolperiod')->group(function () {
    Route::patch('{schoolperiod}', [SchoolPeriodController::class, 'destroys']);
});
/***********************************************************************************************************************
 * CLASSROOMS
 **********************************************************************************************************************/

Route::apiResource('classroom', ClassroomController::class);

Route::prefix('classroom')->group(function () {
    Route::patch('/{classroom}', [ClassroomController::class, 'destroys']);
});

/***********************************************************************************************************************
 * INSTRUCTOR
 **********************************************************************************************************************/

Route::prefix('instructor')->group(function () {
    Route::get('courses',[InstructorController::class,'getCourses']);
    Route::get('instructor-information', [InstructorController::class, 'getInstructorsInformationByCourse']);
    Route::get('type-instructor', [InstructorController::class, 'updateTypeInstructors']);
    Route::get('destroy/{instructor}', [InstructorController::class, 'destroyInstructors']);
});

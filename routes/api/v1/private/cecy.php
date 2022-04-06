<?php

use App\Http\Controllers\V1\Cecy\AuthorityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Cecy\CatalogueController;
use App\Http\Controllers\V1\Cecy\ClassroomController;
use App\Http\Controllers\V1\Cecy\CourseController;
use App\Http\Controllers\V1\Cecy\DetailAttendanceController;
use App\Http\Controllers\V1\Cecy\DetailPlanificationController;
use App\Http\Controllers\V1\Cecy\InstitutionController;
use App\Http\Controllers\V1\Cecy\TopicController;
use App\Http\Controllers\V1\Cecy\PrerequisiteController;
use App\Http\Controllers\V1\Cecy\PlanificationController;
use App\Http\Controllers\V1\Cecy\RequirementController;
use App\Http\Controllers\V1\Cecy\SchoolPeriodController;
use App\Http\Controllers\V1\Cecy\InstructorController;
use \App\Http\Controllers\V1\Cecy\DetailSchoolPeriodController;
use App\Http\Controllers\V1\Cecy\PhotographicRecordController;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Http\Controllers\V1\Cecy\RegistrationController;
use App\Http\Controllers\V1\Cecy\CertificateController;
use App\Http\Controllers\V1\Cecy\AttendanceController;
use App\Http\Controllers\V1\Cecy\ParticipantController;

/***********************************************************************************************************************
 * CATALOGUES
 **********************************************************************************************************************/
Route::controller(InstitutionController::class)->group(function () {
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
    Route::prefix('catalogue')->group(function () {
        Route::get('catalogue', [CatalogueController::class, '']);
    });
});

/***********************************************************************************************************************
 * INSTITUTIONS
 **********************************************************************************************************************/
Route::controller(InstitutionController::class)->group(function () {
    Route::prefix('institutions/{institution}')->group(function () {
        Route::patch('destroy', 'destroy');
        Route::get('show', 'show');
    });

    Route::prefix('institutions')->group(function () {
        Route::patch('destroys', 'destroys');
        Route::post('store', 'store');
        Route::get('catalogue', 'catalogue');
    });
});

Route::apiResource('institutions', InstitutionController::class);

/***********************************************************************************************************************
 * PLANIFICATIONS
 **********************************************************************************************************************/
Route::controller(PlanificationController::class)->group(function () {
    Route::prefix('planifications/{planification}')->group(function () {
        Route::get('', 'getPlanitification');
        Route::put('dates-and-needs-planifications', 'addNeedsOfPlanification');
        // Route::post('create-planifications-course', [PlanificationController::class, 'storePlanificationByCourse']);
        Route::put('planifications-cecy', 'updatePlanificationByCecy');
        Route::put('assign-responsible-cecy', 'updateAssignResponsibleCecy');
        Route::put('assign-code-planification',  'assignCodeToPlanification');
        Route::put('approve-planification',  'approvePlanification');
        Route::get('/curricular-design',  'curricularDesign');
        Route::get('/informe-final',  'informeFinal');
    });

    Route::prefix('planifications')->group(function () {
        Route::get('planifications-period-state', 'getPlanificationsByPeriodState');
        Route::get('by-detail-planification', 'getPlanificationsByDetailPlanification');
        Route::get('course_parallels-works', 'getCoursesParallelsWorkdays');
        Route::get('planfications-course/{course}', 'getPlanificationsByCourse');
        Route::get('kpis/{state}', 'getKpi');
        // Route::put('{planification}', [PlanificationController::class, 'updateStatePlanification']);
        Route::post('course/{course}', 'storePlanificationByCourse');
        Route::get('catalogue/catalogue', 'catalogue');
    });
});
// Route::apiResource('planifications', PlanificationController::class);


/***********************************************************************************************************************
 * DETAIL PLANIFICATIONS
 **********************************************************************************************************************/
Route::controller(DetailPlanificationController::class)->group(function () {
    Route::prefix('detail-planifications/{detail_planification}')->group(function () {
        Route::get('courses/{course}', 'getDetailPlanificationByCourse');
        Route::get('', 'showDetailPlanification');
        Route::put('', 'updateDetailPlanification');
        Route::delete('', 'deleteDetailPlanification');
    });

    Route::prefix('detail-planifications')->group(function () {
        Route::get('planifications/{planification}', 'getDetailPlanificationsByPlanification');
        Route::get('catalogue/catalogue', 'catalogue');
        Route::post('', 'storeDetailPlanification');
    });

    Route::prefix('detail-planification')->group(function () {
        Route::patch('', 'destroysDetailPlanifications');
    });
});
// Route::apiResource('detail-planifications', DetailplanificationController::class);

/***********************************************************************************************************************
 * COURSES
 **********************************************************************************************************************/
Route::controller(CourseController::class)->group(function () {
    Route::prefix('courses')->group(function () {
        Route::prefix('careers/{career}')->group(function () {
            Route::get('', 'getCoursesByCareer');
            Route::post('', 'storeCourse');
        });
        Route::get('', 'getCourses');
        Route::post('', 'storeNewCourse');
        Route::get('private-courses-participant', 'getPrivateCoursesByParticipantType');
        Route::get('private-courses-category/{category}', 'getPrivateCoursesByParticipantTypeAndCategory');
        Route::get('by-responsible', 'getCoursesByResponsibleCourse');
        Route::get('by-instructor/{instructor}', 'getCoursesByInstructor');
        Route::get('by-coodinator', 'getCoursesByCoordinator');
        Route::get('kpi', 'getCoursesKPI');
        Route::get('year-schedule', 'showYearSchedule');

        // Route::put('{course}', [CourseController::class, 'updateStateCourse']);
    });

    Route::prefix('courses/{course}')->group(function () {
        Route::get('', 'show');
        Route::put('', 'approveCourse');
        Route::put('', 'declineCourse');
        Route::put('', 'updateCourse');
        Route::put('', 'updatePlanificationByCourse');

        Route::prefix('')->group(function () {
            Route::get('/topics', [TopicController::class, 'getTopics']);
            Route::get('/topics/all', [TopicController::class, 'getAllTopics']);
            Route::post('/topics', [TopicController::class, 'storesTopics']);
            Route::put('/topics', [TopicController::class, 'updateTopics']);
            Route::delete('/topics/{topic}', [TopicController::class, 'destroyTopic']);
            Route::get('/topics/{topic}', [TopicController::class, 'show']);
            Route::get('/instructors', [TopicController::class, 'getInstructors']);
            Route::delete('/planification/{planification}', [PlanificationController::class, 'destroyPlanification']);
        });
        Route::prefix('')->group(function () {
            Route::get('/prerequisites/all', [PrerequisiteController::class, 'getPrerequisitesAll']);
            Route::get('/prerequisites', [PrerequisiteController::class, 'getPrerequisites']);
            Route::post('/prerequisites', [PrerequisiteController::class, 'storePrerequisite']);
            Route::put('/prerequisites/{prerequisite}', [PrerequisiteController::class, 'updatePrerequisite']);
            Route::delete('/prerequisites/{prerequisite}', [PrerequisiteController::class, 'destroyPrerequisite']);
            Route::patch('/prerequisites/destroys', [PrerequisiteController::class, 'destroysPrerequisites']);
        });
        Route::prefix('')->group(function () {
            Route::put('/curricular-design', 'updateCurricularDesignCourse');
            Route::patch('/general-information', 'updateGeneralInformationCourse');
            Route::patch('/assign-code', 'assignCodeToCourse');
            Route::patch('/not-approve-reason', 'notApproveCourseReason');
            Route::get('/inform-course-needs', 'informCourseNeeds');
            Route::get('/final-report', 'showCourseFinalReport');
            // Route::get('inform-course-needs/{course}', 'App\Http\Controllers\V1\Cecy\CourseController@informCourseNeeds');
        });
        Route::prefix('images')->group(function () {
            Route::get('{image}', 'indexPublicImages');
            Route::post('', 'uploadPublicImage');
        });
    });
});
Route::apiResource('courses', CourseController::class);

/***********************************************************************************************************************
 * 
 **********************************************************************************************************************/
Route::get('/inform', function () {
    $pdf = PDF::loadView('reports/informe-final');
    $pdf->setOptions([
        'page-size' => 'a4'
    ]);

    return $pdf->inline('Informe.pdf');
});

/***********************************************************************************************************************
 * DETAIL ATTENDANCES
 **********************************************************************************************************************/

Route::controller(DetailAttendanceController::class)->group(function () {
    Route::prefix('detail-attendances/{detail_attendance}')->group(function () {
        Route::get('', 'showAttendanceParticipant');
        Route::get('', 'getDetailAttendancesByParticipantWithOutPaginate');
        Route::get('', 'getDetailAttendancesByParticipant');
        Route::get('', 'getCurrentDateDetailAttendance');
        Route::put('', 'updateDetailPlanification');
        Route::put('', 'updatedetailPlanificationByCecy');
        Route::patch('delete', 'deleteDetailPlanification');
    });

    Route::prefix('detail-attendances')->group(function () {
        Route::patch('destroys', 'destroysDetailPlanifications');
        Route::get('catalogue', 'catalogue');
    });
});
Route::apiResource('detail-attendances', DetailAttendanceController::class);

/***********************************************************************************************************************
 * CERTIFICATES
 **********************************************************************************************************************/
Route::prefix('certificate')->group(function () {

    Route::get('excel-dates', [CertificateController::class, 'ExcelData']);
    Route::post('excel-reading', [CertificateController::class, 'ExcelImport']);
    Route::post('pdf-student', [CertificateController::class, 'generatePdfStudent']);
    Route::get('pdf-instructor', [CertificateController::class, 'generatePdfInstructor']);

    Route::post('registration/{registration}/catalogue/{catalogue}/file/{file}', [CertificateController::class, 'downloadCertificateByParticipant']);
    Route::get('catalogue/{catalogue}/file/{file}', [CertificateController::class, 'downloadFileCertificates']);
    Route::post('catalogue/{catalogue}', [CertificateController::class, 'uploadFileCertificate']);
    Route::post('firm/catalogue/{catalogue}', [CertificateController::class, 'uploadFileCertificateFirm']);
});

/***********************************************************************************************************************
 * SCHOOL PERIODS
 **********************************************************************************************************************/

Route::controller(SchoolPeriodController::class)->group(function () {
    Route::prefix('school-periods/{school_period}')->group(function () {
        Route::put('update', 'update');
        Route::patch('destroy', 'destroy');
    });

    Route::prefix('school-periods')->group(function () {
        Route::post('store', 'store');
        Route::patch('destroys', 'destroys');
        Route::get('catalogue', 'catalogue');
    });
});
Route::apiResource('school-periods', SchoolPeriodController::class);

/***********************************************************************************************************************
 * CLASSROOMS
 **********************************************************************************************************************/

Route::controller(ClassroomController::class)->group(function () {
    Route::prefix('classrooms/{classroom}')->group(function () {
        Route::put('update', 'update');
        Route::patch('destroy', 'destroy');
    });

    Route::prefix('classrooms')->group(function () {
        Route::patch('destroys', 'destroys');
        Route::post('store', 'store');
        Route::get('catalogue', 'catalogue');
    });
});
Route::apiResource('classroom', ClassroomController::class);

/***********************************************************************************************************************
 * INSTRUCTORS
 **********************************************************************************************************************/

Route::controller(InstructorController::class)->group(function () {
    Route::prefix('instructors/{instructor}')->group(function () {
        Route::put('type-instructor', 'updateTypeInstructor');
        Route::put('state-instructor', 'updateStateInstructor');
    });

    Route::prefix('instructors')->group(function () {
        Route::get('catalogue', 'catalogue');
        Route::post('create', 'storeInstructor');
        Route::post('create-instructors', 'storeInstructors');
        Route::get('instructor-information', 'getInstructorsInformationByCourse');
        // Route::get('courses', [InstructorController::class, 'getCourses']);
        // Route::get('instructor-courses', [InstructorController::class, 'getInstructorByCourses']);
        // Route::get('destroy/{instructor}', [InstructorController::class, 'destroyInstructors']);

    });
});
Route::apiResource('instructors', InstructorController::class);

/***********************************************************************************************************************
 * REGISTRATIONS
 **********************************************************************************************************************/
Route::prefix('registration')->group(function () {
    Route::post('register-student/{detailPlanification}', [RegistrationController::class, 'registerStudent']);
    Route::post('register-student', [RegistrationController::class, 'registerStudent']);
    Route::get('participant/{detailPlanification}', [RegistrationController::class, 'getParticipant']);
    Route::patch('nullify-registration', [RegistrationController::class, 'nullifyRegistration']);
    Route::patch('nullify-registrations', [RegistrationController::class, 'nullifyRegistrations']);
    Route::patch('participant-grades/{registration}', [RegistrationController::class, 'updateGradesParticipant']);
});

/***********************************************************************************************************************
 * PARTICIPANTS
 **********************************************************************************************************************/
Route::controller(ParticipantController::class)->group(function () {
    Route::prefix('participants/{participant}')->group(function () {
        // Route::put('update-registration/{registration}', 'participantRegistrationStateModification');
        Route::put('update-state', [ParticipantController::class, 'acceptParticipant']);
        Route::delete('destroy', [ParticipantController::class, 'destroyParticipant']);
        Route::get('information', [ParticipantController::class, 'getParticipants']);
        Route::put('update', [ParticipantController::class, 'updateParticipant']);
    });

    Route::prefix('participants')->group(function () {
        Route::get('detail-planification/{detailPlanification}', 'getParticipantsByPlanification');
        Route::get('information/{registration}', 'getParticipantInformation');
        Route::patch('participant-registration/{registration}', 'registerParticipant');
    });
});

Route::apiResource('participants', ParticipantController::class);

/***********************************************************************************************************************
 * DETAIL SCHOOL PERIOD
 **********************************************************************************************************************/
Route::apiResource('detail-school-periods', DetailSchoolPeriodController::class);
Route::prefix('detail-school-period')->group(function () {
    Route::patch('/{detail-school-period}', [DetailSchoolPeriodController::class, 'destroys']);
});

/*
******************************************************************************************************************
 * REQUERIMENTS
 **********************************************************************************************************************/
Route::controller(RequirementController::class)->group(function () {
    Route::prefix('requirement')->group(function () {
        Route::get('file', 'showFile');
        Route::get('image', 'showImage');
    });

    Route::prefix('requirement')->group(function () {
        Route::get('catalogue', 'catalogue');
        Route::get('', 'getAllRequirement');
        Route::get('/{requirements}', 'getRequirement');
        Route::post('/{requirements}', 'storeRequirement');
        Route::put('/{requirements}', 'updateRequirement');
        Route::delete('/{requirements}', 'destroy');
    });
});
Route::apiResource('requirements', RequirementController::class);

/***********************************************************************************************************************
 * AUTHORITIES
 **********************************************************************************************************************/

Route::apiResource('authorities', AuthorityController::class);

Route::prefix('authorities')->group(function () {
    Route::get('', [AuthorityController::class, 'getAuthoritys']);
    Route::post('', [AuthorityController::class, 'storeAuthority']);
    Route::put('', [AuthorityController::class, 'updateAuthority']);
});
Route::prefix('authority')->group(function () {
    Route::delete('destroys', [AuthorityController::class, 'deleteAuthoritys']);
});

/***********************************************************************************************************************
 * ATTENDANCES
 **********************************************************************************************************************/

Route::apiResource('attendances', AttendanceController::class);

Route::prefix('attendance')->group(function () {
    Route::get('detail/{detailPlanification}', [AttendanceController::class, 'getAttendancesByDetailPlanification']);
    Route::delete('destroys', [AuthorityController::class, 'deleteAttendance']);
});

Route::prefix('pdf')->group(function () {
    Route::get('photographic-record/{course}', [AttendanceController::class, 'showPhotographicRecord']);
    Route::get('year-schedule/{year}', [CourseController::class, 'showYearSchedule']);
    Route::get('attendance-evaluation/{course}', [AttendanceController::class, 'attendanceEvaluation']);
    Route::get('year-schedule', [CourseController::class, 'showYearSchedule']);

    // Route::get('inform-course-needs/{course}', 'App\Http\Controllers\V1\Cecy\CourseController@informCourseNeeds');

    // Route::get('inform-course-needs/{course}', [CourseController::class, 'informCourseNeeds']);

});


/***********************************************************************************************************************
 * RECORDS
 **********************************************************************************************************************/
Route::controller(RecordController::class)->group(function () {
    Route::prefix('records/{record}')->group(function () {
        Route::patch('destroy', 'destroy');
        Route::get('show', 'show');
    });

    Route::prefix('record')->group(function () {
        //Route::get('{photographicRecord}', [PhotographicRecordController::class, 'show']);
        //Route::get('detail/{detailPlanification}', [PhotographicRecordController::class, 'getDetails']);
        Route::patch('destroys', 'destroys');
        Route::post('store', 'store');
    });
});
Route::apiResource('records', PhotographicRecordController::class);
/*****************************************
 * REGISTRATIONS 
 ****************************************/

Route::prefix('registration')->group(function () {
    Route::get('courses-by-participant', [RegistrationController::class, 'getCoursesByParticipant']);
    Route::get('courses-by-participant/{registration}', [RegistrationController::class, 'getCoursesByParticipant']);
    //ruta para consulta las notas de registration
    //Route::get('courses-by-participant', [RegistrationController::class, 'getCoursesByParticipant']);
    Route::get('records-returned-by-registration', [RegistrationController::class, 'recordsReturnedByRegistration']);
    Route::get('show-participants', [RegistrationController::class, 'showParticipants']);
    Route::get('download-file', [RegistrationController::class, 'downloadFile']);
    Route::post('nullify-registrations', [RegistrationController::class, 'nullifyRegistrations']);
    Route::patch('nullify-registration/{registration}', [RegistrationController::class, 'nullifyRegistration']);
    Route::get('show-record-competitor/{detailPlanification}', [RegistrationController::class, 'showRecordCompetitor']);
    Route::patch('show-participant-grades', [RegistrationController::class, 'ShowParticipantGrades']);
    Route::put('upload-file', [RegistrationController::class, 'uploadFile']);
    Route::get('download-file-grades', [RegistrationController::class, 'downloadFileGrades']);
    Route::get('show-file', [RegistrationController::class, 'showFile']);
    Route::patch('destroy-file', [RegistrationController::class, 'destroyFile']);
});
Route::prefix('topic/{topic}')->group(function () {
    Route::prefix('file')->group(function () {
        Route::get('{file}/download', [TopicController::class, 'downloadFile']);
        Route::get('download', [TopicController::class, 'downloadFiles']);
        Route::get('', [TopicController::class, 'indexFiles']);
        Route::get('{file}', [TopicController::class, 'showFile']);
        Route::post('', [TopicController::class, 'uploadFile']);
        Route::post('{file}', [TopicController::class, 'updateFile']);
        Route::delete('{file}', [TopicController::class, 'destroyFile']);
        Route::patch('', [TopicController::class, 'destroyFiles']);
    });
});

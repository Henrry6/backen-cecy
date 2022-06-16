<?php

use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Cecy\DetailSchoolPeriodController;
use App\Http\Controllers\V1\Cecy\AttendanceController;
use App\Http\Controllers\V1\Cecy\AuthorityController;
use App\Http\Controllers\V1\Cecy\CatalogueController;
use App\Http\Controllers\V1\Cecy\CertificateController;
use App\Http\Controllers\V1\Cecy\ClassroomController;
use App\Http\Controllers\V1\Cecy\CourseController;
use App\Http\Controllers\V1\Cecy\DetailAttendanceController;
use App\Http\Controllers\V1\Cecy\DetailPlanificationController;
use App\Http\Controllers\V1\Cecy\InstitutionController;
use App\Http\Controllers\V1\Cecy\InstructorController;
use App\Http\Controllers\V1\Cecy\ParticipantController;
use App\Http\Controllers\V1\Cecy\PhotographicRecordController;
use App\Http\Controllers\V1\Cecy\PlanificationController;
use App\Http\Controllers\V1\Cecy\PrerequisiteController;
use App\Http\Controllers\V1\Cecy\RegistrationController;
use App\Http\Controllers\V1\Cecy\RequirementController;
use App\Http\Controllers\V1\Cecy\SchoolPeriodController;
use App\Http\Controllers\V1\Cecy\TopicController;


/***********************************************************************************************************************
 * CATALOGUES
 **********************************************************************************************************************/
Route::controller(CatalogueController::class)->group(function () {
    Route::prefix('cecy-catalogue/{catalogue}')->group(function () {
    });
    Route::prefix('cecy-catalogue')->group(function () {
        Route::get('catalogue', [CatalogueController::class, 'catalogue']);
    });
});

/***********************************************************************************************************************
 * INSTITUTIONS
 **********************************************************************************************************************/
Route::controller(InstitutionController::class)->group(function () {
    Route::prefix('institutions/{institution}')->group(function () {
    });

    Route::prefix('institutions')->group(function () {
        Route::patch('destroys', 'destroys');
        Route::get('catalogue', 'catalogue');
    });
});

Route::apiResource('institutions', InstitutionController::class);

/***********************************************************************************************************************
 * PLANIFICATIONS
 **********************************************************************************************************************/
Route::controller(PlanificationController::class)->group(function () {
    Route::prefix('planifications/{planification}')->group(function () {
        Route::put('approve', 'approve');
        Route::put('assign-code', 'assignCode');
        Route::patch('assign-responsible-cecy', 'assignResponsibleCecy');
        Route::get('detail-planifications', 'getDetailPlanificationsByPlanification');
        Route::put('initial-planification', 'updateInitialPlanification');
        Route::put('planifications-cecy', 'updatePlanificationByCecy'); // BORRAR
    });

    Route::prefix('planifications')->group(function () {
        Route::get('period-states', 'getCurrentPlanificationsByAuthority');
        Route::get('detail-planifications', 'getPlanificationsByDetailPlanification'); // no existe el metodo
        Route::get('course-parallels-works', 'getCoursesParallelsWorkdays'); // no existe el metodo
        Route::get('courses/{course}', 'getPlanificationsByCourse');
        Route::get('kpis/{state}', 'getKpi');
        Route::post('courses/{course}', 'storePlanificationByCourse');
        Route::get('catalogue', 'catalogue');
    });
});
Route::apiResource('planifications', PlanificationController::class);

// REVISAR DESDE AQUI
/***********************************************************************************************************************
 * DETAIL PLANIFICATIONS
 **********************************************************************************************************************/
Route::controller(DetailPlanificationController::class)->group(function () {
    Route::prefix('detail-planifications/{detail_planification}')->group(function () {
        Route::get('detail-course/{course}', 'getDetailPlanificationsByCourse');
        Route::post('instructors-assignment', 'assignInstructors');
        Route::put('detail-planification-proposal','updateDetailPlanificationProposal');
    });

    Route::prefix('detail-planifications')->group(function () {
        Route::get('catalogue', 'catalogue');
        Route::patch('destroys', 'destroys');
    });
});
Route::apiResource('detail-planifications', DetailplanificationController::class);

/***********************************************************************************************************************
 * COURSES
 **********************************************************************************************************************/
Route::controller(CourseController::class)->group(function () {
    Route::prefix('courses')->group(function () {
        Route::prefix('careers')->group(function () {
        });

        Route::prefix('careers/{career}')->group(function () {
            Route::get('', 'getCoursesByCareer');
            Route::post('', 'storeCourseByCareer');
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
        Route::prefix('cecy-responsible')->group(function () {
            Route::put('approve', 'approveCourse');
            Route::get('decline', 'declineCourse');

            Route::prefix('files')->group(function () {
                Route::get('{file}/download', 'downloadFile');
                Route::get('', 'indexFiles');
                Route::get('{file}', 'showFile');
                Route::post('', 'uploadFile');
                Route::put('{file}', 'updateFile');
                Route::delete('{file}', 'destroyFile');
                Route::patch('', 'destroyFiles');
            });

            Route::prefix('images')->group(function () {
                Route::get('{image}/download', 'downloadImage');
                Route::get('', 'indexImages');
                Route::get('public', 'indexPublicImages');
                Route::get('{image}', 'showImage');
                Route::post('public', 'uploadPublicImage');
                Route::put('{image}', 'updateImage');
                Route::delete('{image}', 'destroyImage');
                Route::patch('', 'destroyImages');
            });
        });

        Route::put('career-coordinator', 'updateCourseNameAndDuration');
        Route::delete('career-coordinator', 'destroyCourse');

        Route::prefix('')->group(function () {
            Route::get('/topics', [TopicController::class, 'getTopics']);
            Route::get('/topics/all', [TopicController::class, 'getAllTopics']);
            Route::post('/topics', [TopicController::class, 'storesTopics']);
            Route::put('/topics', [TopicController::class, 'updateTopics']);
            Route::delete('/topics/{topic}', [TopicController::class, 'destroyTopic']);
            Route::get('/topics/{topic}', [TopicController::class, 'show']);
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
    });
});
// Route::apiResource('courses', CourseController::class);

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
        Route::get('', 'showAttendanceParticipant'); // asistencia de un estudiante registrado .// Santillan-Molina
        Route::get('', 'getDetailAttendancesByParticipantWithOutPaginate'); // assitencias de un participante ordenada y con paginacion .// Santillan-Molina
        Route::get('', 'getDetailAttendancesByParticipant'); // revision con el anterior metodo por que parece que hace lo mismo.// Santillan-Molina
        Route::get('', 'getCurrentDateDetailAttendance'); //  asistencias de acuerdo a la fecha del detallle de la planificacion.// Santillan-Molina
        Route::put('', 'updateDetailPlanification'); // no existe el metodo en el controllador.// Santillan-Molina
        Route::put('', 'updatedetailPlanificationByCecy'); // no existe el metodo en el controllador.// Santillan-Molina
        Route::patch('delete', 'deleteDetailPlanification'); // no existe el metodo en el controllador.// Santillan-Molina
    });

    Route::prefix('detail-attendances')->group(function () {
        Route::patch('create', 'storeDetailAttendance');  // actualizacion de la asistencia.// Santillan-Molina
        Route::patch('destroys', 'destroysDetailPlanifications'); // no existe el metodo.// Santillan-Molina
        Route::get('catalogue', 'catalogue'); // catalogo del tipo de asistencia.// Santillan-Molina
    });
});
Route::apiResource('detail-attendances', DetailAttendanceController::class); //metodo generales // Santillan-Molina

/***********************************************************************************************************************
 * CERTIFICATES -- Quemag
 **********************************************************************************************************************/
Route::prefix('certificate')->group(function () {

    Route::get('excel-dates', [CertificateController::class, 'ExcelData']);   //Muestra Datos Guardados del Excell 
    Route::post('excel-reading', [CertificateController::class, 'ExcelImport']);   //Importa-Lee Datos del Excell y los guarda en BD
    Route::post('pdf-student', [CertificateController::class, 'generatePdfStudent']); //Genera el PDF del estudiante
    Route::get('pdf-instructor', [CertificateController::class, 'generatePdfInstructor']); //Genera el PDF del Instructor

    //Borrar--- Route::post('registration/{registration}/catalogue/{catalogue}/file/{file}', [CertificateController::class, 'downloadCertificateByParticipant']);
    //Borrar--- Route::get('catalogue/{catalogue}/file/{file}', [CertificateController::class, 'downloadFileCertificates']);
    //Borrar--- Route::post('catalogue/{catalogue}', [CertificateController::class, 'uploadFileCertificate']);
    //Borrar--- Route::post('firm/catalogue/{catalogue}', [CertificateController::class, 'uploadFileCertificateFirm']);

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
        Route::put('updateInstructor', 'updateInstructor');
        Route::delete('destroy', 'destroy');
    });

    Route::prefix('instructors')->group(function () {
        Route::get('catalogue', 'catalogue');
        Route::post('create', 'storeInstructor');
        Route::post('create-instructors', 'storeInstructors');
        Route::get('instructor-information', 'getInstructorsInformationByCourse');
        Route::get('authorized-instructors/detail-planifications/{detail_planification}', 'getAuthorizedInstructorsOfCourse');
        Route::get('detail-planifications/{detail_planification}', 'getAssignedInstructors');
        Route::delete('destroys', 'destroyInstructors');

        // Route::get('courses', [InstructorController::class, 'getCourses']); cursos de un instructor desde la planificacion Santillan
        // Route::get('instructor-courses', [InstructorController::class, 'getInstructorByCourses']); cursos de un instructor desde el detalle de planificacion Santillan


    });
});
Route::apiResource('instructors', InstructorController::class);

/***********************************************************************************************************************
 * REGISTRATIONS
 **********************************************************************************************************************/
Route::controller(RegistrationController::class)->group(function () {
    Route::prefix('registrations/{registration}')->group(function () {
    });

    Route::prefix('registrations')->group(function () {
        Route::post('register-student/{detailPlanification}', 'registerStudent');
        Route::post('register-student', 'registerStudent');
        Route::get('participant/{detailPlanification}', 'getParticipant');
        Route::patch('nullify-registration', 'nullifyRegistration');
        Route::patch('nullify-registrations', 'nullifyRegistrations');
        Route::patch('participant-grades/{registration}', 'updateGradesParticipant');
    });
});
Route::apiResource('registrations', RegistrationController::class);


/***********************************************************************************************************************
 * PARTICIPANTS
 **********************************************************************************************************************/
Route::controller(ParticipantController::class)->group(function () {
    Route::prefix('participants/{participant}')->group(function () {
        Route::put('update-registration/{registration}', 'participantRegistrationStateModification');
        Route::get('accept-participant', 'updateParticipantState');
        Route::get('decline-participant', 'declineParticipant');
        Route::post('participant-registration-user', 'createParticipantUser');
        Route::delete('delete-participant', 'destroyParticipant');
        Route::put('update-participant-user', 'updateParticipantUser');
        Route::delete('destroy-participant', 'destroyParticipant');
    });

    Route::prefix('participants')->group(function () {
        Route::get('detail-planification/{detailPlanification}', 'getParticipantsByPlanification');
        Route::get('information/{registration}', 'getParticipantInformation');
        Route::get('information', 'index');
        Route::patch('participant-registration/{registration}', 'registerParticipant');
        Route::post('create-participant-user', 'createParticipantUser');
    });
});
Route::apiResource('participants', ParticipantController::class);

/***********************************************************************************************************************
 * DETAIL SCHOOL PERIODS
 **********************************************************************************************************************/
Route::apiResource('detail-school-periods', DetailSchoolPeriodController::class);
Route::prefix('detail-school-period')->group(function () {
    Route::patch('{detail-school-period}', [DetailSchoolPeriodController::class, 'destroys']);
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
Route::prefix('authorities')->group(function () {
    Route::get('catalogue', [AuthorityController::class, 'catalogue']);
    Route::post('', [AuthorityController::class, 'storeAuthority']);
    Route::put('', [AuthorityController::class, 'updateAuthority']);
});

Route::prefix('authority')->group(function () {
    Route::delete('destroys', [AuthorityController::class, 'deleteAuthoritys']);
});

// Route::apiResource('authorities', AuthorityController::class);

/***********************************************************************************************************************
 * ATTENDANCES / Santillan-Molina
 **********************************************************************************************************************/

Route::apiResource('attendances', AttendanceController::class);

Route::prefix('attendance')->group(function () {
    Route::get('detail/{detailPlanification}', [AttendanceController::class, 'getAttendancesByDetailPlanification']); //asistencias por el detalle de la planificacion santillan
    Route::delete('destroys', [AuthorityController::class, 'deleteAttendance']); // eliminacion santillan
});

Route::prefix('pdf')->group(function () {
    Route::get('photographic-record/{course}', [AttendanceController::class, 'showPhotographicRecord']);
    Route::get('year-schedule/{year}', [CourseController::class, 'showYearSchedule']);
    Route::get('attendance-evaluation/{course}', [AttendanceController::class, 'AttendanceEvaluation']);
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
        //Route::get('{photographicRecord}', [PhotographicRecordController::class, 'show']); // registro fotografico individual Santillan
        //Route::get('detail/{detailPlanification}', [PhotographicRecordController::class, 'getDetails']); // registro fotografico de todo el curso desde el detalle de planificaion-Santillan
        Route::patch('destroys', 'destroys');
        Route::post('store', 'store');
    });
});
Route::apiResource('records', PhotographicRecordController::class); // crud del registro fotografico para pruebas Santillan

/*****************************************
 * REGISTRATIONS
 ****************************************/
Route::controller(RegistrationController::class)->group(function () {
    Route::prefix('registrations/{registration}')->group(function () {
    });

    Route::prefix('registrations')->group(function () {
        Route::get('courses-by-participant', 'getCoursesByParticipant');
        Route::get('courses-by-participant/{registration}', 'getCoursesByParticipant');
        //ruta para consulta las notas de registration
        //Route::get('courses-by-participant', [RegistrationController::class, 'getCoursesByParticipant']);
        Route::get('records-returned-by-registration', 'recordsReturnedByRegistration');
        Route::get('show-participants', 'showParticipants');
        Route::get('download-file', 'downloadFile');
        Route::post('nullify-registrations', 'nullifyRegistrations');
        Route::patch('nullify-registration/{registration}', 'nullifyRegistration');
        Route::get('show-record-competitor/{detailPlanification}', 'showRecordCompetitor');
        Route::patch('show-participant-grades', 'ShowParticipantGrades');
        Route::put('upload-file', 'uploadFile');
        Route::get('download-file-grades', 'downloadFileGrades');
        Route::get('show-file', 'showFile');
        Route::patch('destroy-file', 'destroyFile');
    });
});

/*****************************************
 * TOPICS
 ****************************************/
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

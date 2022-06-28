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
        Route::put('initial-planification', 'updateInitialPlanification'); //Rivas-Pplanificacion
        Route::patch('needs', 'addNeeds'); // Pérez
        Route::get('detail-planifications', 'getDetailPlanifications');
    });

    Route::prefix('planifications')->group(function () {
        Route::get('period-states', 'getCurrentPlanificationsByAuthority'); //Rivas-matriculacion
        Route::patch('destroys', 'destroys'); //Rivas
        Route::prefix('courses/{course}')->group(function () {
            Route::get('', 'getPlanificationsByCourse'); //Rivas, Pérez, pplanificacion
            Route::post('', 'storePlanificationByCourse'); //Rivas - pplanificacion
        });
        Route::get('detail-planifications', 'getPlanificationsByDetailPlanification'); // no existe el metodo
        Route::get('course-parallels-works', 'getCoursesParallelsWorkdays'); // no existe el metodo
        Route::get('kpis/{state}', 'getKpi');
        Route::get('catalogue', 'catalogue');
    });
});
Route::apiResource('planifications', PlanificationController::class);

/***********************************************************************************************************************
 * DETAIL PLANIFICATIONS
 **********************************************************************************************************************/
Route::controller(DetailPlanificationController::class)->group(function () {
    Route::prefix('detail-planifications/{detail_planification}')->group(function () {
        Route::get('detail-course/{course}', 'getDetailPlanificationsByCourse');
        Route::get('participants', 'getParticipantsByDetailPlanification'); // Rivas - matriculacion
        Route::post('instructors-assignment', 'assignInstructors'); // Pérez
        Route::put('detail-planification-proposal', 'updateDetailPlanificationProposal'); //
    });

    Route::prefix('detail-planifications')->group(function () {
        Route::get('instructor-courses', 'getInstructorByCourses');//santillan
        Route::get('catalogue', 'catalogue');
        Route::patch('destroys', 'destroys'); //Pérez
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
            Route::get('', 'getCoursesByCareer'); //Rivas -pcurso
            Route::post('', 'storeCourseByCareer'); //Rivas - pcurso
        });

        Route::get('', 'getCourses');
        Route::post('', 'storeNewCourse');
        Route::get('private-courses-participant', 'getPrivateCoursesByParticipantType'); //Guachagmira
        Route::get('private-courses-category/{category}', 'getPrivateCoursesByParticipantTypeAndCategory'); //Guachagmira
        Route::get('by-responsible', 'getCoursesByResponsibleCourse'); //Matango
        Route::get('by-instructor/{instructor}', 'getCoursesByInstructor');
        Route::get('by-coodinator', 'getCoursesByCoordinator');
        Route::get('kpi', 'getCoursesKPI');
        Route::get('year-schedule', 'showYearSchedule');

        // Route::put('{course}', [CourseController::class, 'updateStateCourse']);
    });

    Route::prefix('courses/{course}')->group(function () {
        Route::get('', 'show');
        Route::put('approve', 'approveCourse'); //sin responsable
        Route::put('decline', 'declineCourse'); //sin responsable

        //Para subir acta de curso aprobado
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

        Route::put('initial-course', 'updateInitialCourse'); //Rivas - pcurso
        Route::delete('initial-course', 'destroyCourse'); //Rivas - pcurso
        Route::patch('initial-course', 'destroysCourse'); //Rivas - pcurso

        Route::prefix('')->group(function () {
            Route::get('/topics', [TopicController::class, 'getTopics']); //Guachagmira - Alvarado
            Route::post('/topics', [TopicController::class, 'storesTopics']); //Alvarado
            Route::put('/topics', [TopicController::class, 'updateTopics']); // Alvarado
            Route::delete('/topics/{topic}', [TopicController::class, 'destroyTopic']); //Alvarado
        });
        Route::prefix('')->group(function () {
            Route::get('/prerequisites', [PrerequisiteController::class, 'getPrerequisites']); //Guachagmira -Alvarado
            Route::post('/prerequisites', [PrerequisiteController::class, 'storePrerequisite']); // Alvarado
            Route::delete('/prerequisites/{prerequisite}', [PrerequisiteController::class, 'destroyPrerequisite']); // Alvarado
        });
        Route::prefix('')->group(function () {
            Route::put('/curricular-design', 'updateCurricularDesignCourse'); // Alvarado
            Route::patch('/general-information', 'updateGeneralInformationCourse'); //Matango
            Route::patch('/assign-code', 'assignCodeToCourse');
            Route::patch('/not-approve-reason', 'notApproveCourseReason');
            Route::get('/inform-course-needs', 'informCourseNeeds'); //Rivera
            Route::get('/informe-final', 'informeFinal'); //Salazar
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
        Route::prefix('detail-attendances')->group(function () {
            Route::get('attendances/{attendance}', 'getByAttendance');
            Route::get('/{detail_planification}/no-paginate', 'getByRegistration'); //detalle de asistencia por paginado .// Santillan-Molina
            Route::get('/{detail_planification}', [DetailAttendanceController::class, 'getDetailAttendancesByParticipant']);// trae el detalle de asistencia del participante.  Molina
            Route::get('/{detail_planification}/current-date', [DetailAttendanceController::class, 'getCurrentDateDetailAttendance']);//obtiene la fecha actual del detalle de asistencia.  Molina

        });

        Route::prefix('detail-attendances/{detail_attendance}')->group(function () {
            Route::patch('type', 'updateType');  // actualizacion del tipo.// Santillan-Molina
            Route::get('attendances/{attendance}', 'getByAttendance');  // asistencias por id.
            Route::patch('types/{type}', 'changeType');  // actualizacion del tipo.// Santillan-Molina
            Route::get('', 'getByRegistration'); // assitencias de un participante ordenada y con paginacion .// Santillan-Molina
        });
    });

    Route::apiResource('detail-attendances', DetailAttendanceController::class); //metodo generales // Santillan-Molina


/***********************************************************************************************************************
 * CERTIFICATES -- Quemag
 **********************************************************************************************************************/
Route::prefix('certificates')->group(function () {
    Route::prefix('certificates/{certificate}')->group(function () {
        Route::get('excel-dates', [CertificateController::class, 'ExcelData']);   //Muestra Datos Guardados del Excell
        Route::post('excel-reading', [CertificateController::class, 'ExcelImport']);   //Importa-Lee Datos del Excell y los guarda en BD
        Route::post('students/pdf', [CertificateController::class, 'generatePdfStudent']); //Genera el PDF del estudiante
        Route::get('instructors/pdf', [CertificateController::class, 'generatePdfInstructor']); //Genera el PDF del Instructor
    });

    Route::prefix('certificates')->group(function () {
        Route::get('excel-dates', [CertificateController::class, 'ExcelData']);   //Muestra Datos Guardados del Excell
        Route::post('excel-reading', [CertificateController::class, 'ExcelImport']);   //Importa-Lee Datos del Excell y los guarda en BD
        Route::post('students/{student}/pdf', [CertificateController::class, 'generatePdfStudent']); //Genera el PDF del estudiante
        Route::get('instructors/pdf', [CertificateController::class, 'generatePdfInstructor']); //Genera el PDF del Instructor
    });
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
    });

    Route::prefix('school-periods')->group(function () {
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
    });
    Route::prefix('classrooms')->group(function () {
        Route::patch('destroys', 'destroys');
        Route::get('catalogue', 'catalogue');
    });
});
Route::apiResource('classroom', ClassroomController::class);

/***********************************************************************************************************************
 * INSTRUCTORS
 **********************************************************************************************************************/
Route::controller(InstructorController::class)->group(function () {
    Route::prefix('instructors/{instructor}')->group(function () {
        Route::put('state-type', 'updateInstructorStateAndType'); //Rivera
    });

    Route::prefix('instructors')->group(function () {
        Route::get('catalogue', 'catalogue');
        Route::post('stores', 'storeInstructors'); //Rivera
        Route::get('courses/{course}', 'getInstructorsByCourseProfile'); //Perez
        Route::get('detail-planifications/{detail_planification}', 'getAssignedInstructorsByDetailPlanification'); //Perez
        Route::delete('destroys', 'destroys');
    });
});
Route::apiResource('instructors', InstructorController::class);

/***********************************************************************************************************************
 * PARTICIPANTS
 **********************************************************************************************************************/
Route::controller(ParticipantController::class)->group(function () {
    Route::prefix('participants/{participant}')->group(function () {
        Route::put('update-registration/{registration}', 'participantRegistrationStateModification'); // revisar para cambiar y separar en 3 metodos y en otro controlador
        Route::patch('approve', 'approveParticipant'); //Salazar
        Route::patch('decline', 'declineParticipant'); //Salazar
    });

    Route::prefix('participants')->group(function () {
    });
});
Route::apiResource('participants', ParticipantController::class);

/***********************************************************************************************************************
 * DETAIL SCHOOL PERIODS
 **********************************************************************************************************************/
Route::prefix('detail-school-periods')->group(function () {
    Route::patch('{detail-school-period}', [DetailSchoolPeriodController::class, 'destroys']);
});

Route::apiResource('detail-school-periods', DetailSchoolPeriodController::class);
/*
******************************************************************************************************************
 * REQUIREMENTS
 **********************************************************************************************************************/
Route::controller(RequirementController::class)->group(function () {
    Route::prefix('requirements/{requirement}')->group(function () {
        Route::get('file', 'showFile');
        Route::get('image', 'showImage');
    });

    Route::prefix('requirements')->group(function () {
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
 * ATTENDANCES / Santillan-Molina
 **********************************************************************************************************************/
Route::prefix('attendances')->group(function () {
    Route::get('detail-planifications/{detail_planification}', [AttendanceController::class, 'getByDetailPlanification']);
    Route::delete('detail-planifications/{detail_planification}', [AttendanceController::class, 'destroyAttendance']); // eliminacion santillan
    Route::delete('destroys', [AttendanceController::class, 'destroys']);
});

Route::prefix('pdf')->group(function () {
    Route::get('attendance-evaluation/{course}', [AttendanceController::class, 'attendanceEvaluation']); //Salazar
    Route::get('curricular-design/{planification}', [PlanificationController::class, 'curricularDesign']); //Salazar
    Route::get('informe-final/{planification}', [PlanificationController::class, 'informeFinal']); //Salazar
    Route::get('photographic-record/{course}', [AttendanceController::class, 'showPhotographicRecord']); //Rivera
    Route::get('year-schedule/{year}', [CourseController::class, 'showYearSchedule']); //Rivera
    Route::get('year-schedule', [CourseController::class, 'showYearSchedule']); //Rivera
    Route::get('show-record-competitor/{detailPlanification}', [RegistrationController::class, 'showRecordCompetitor']);

});

Route::prefix('records')->group(function (){
    Route::get('detail-record/{detail_planification}', [PhotographicRecordController::class, 'getPhotograficRecord']);//asistencias por el detalle de la planificacion santillan
});

Route::apiResource('attendances', AttendanceController::class);

/*****************************************
 * REGISTRATIONS
 ****************************************/
Route::controller(RegistrationController::class)->group(function () {
    Route::prefix('registrations/{registration}')->group(function () {
        Route::patch('nullify-registration', 'nullifyRegistration'); //Rivas - matriculacion
        Route::put('register', 'register'); //Rivas -matriculacion
        Route::put('review', 'setRegistrationinReview'); //Rivas - matriculacion
        Route::delete('eliminate', 'setRegistrationinReview'); //Rivas - matriculacion
        Route::put('reenroll', 'setRegistrationinReview'); //Rivas - matriculacion

    });

    Route::prefix('registrations')->group(function () {
        Route::put('participant-grades/{registration}', 'updateGradesParticipant'); // Actualizar notas
        Route::get('courses/participant', 'getCoursesByParticipant'); // Molina
        Route::get('participant/{detailPlanification}', 'getParticipantByDetailPlanification');//santillan
        Route::post('register-student', 'registerStudent');
        Route::patch('nullify-registrations', 'nullifyRegistrations'); //Rivas - matriculacion
    });
});
Route::apiResource('registrations', RegistrationController::class);

//photofraphicRecords files-images
Route::prefix('record/{record}')->group(function () {
    Route::prefix('file')->group(function () {
        Route::get('{file}/download', [PhotographicRecordController::class, 'downloadFile']);
        Route::get('download', [PhotographicRecordController::class, 'downloadFiles']);
        Route::get('', [PhotographicRecordController::class, 'indexFiles']);
        Route::get('{file}', [PhotographicRecordController::class, 'showFile']);
        Route::post('', [PhotographicRecordController::class, 'uploadFile']);
        Route::post('{file}', [PhotographicRecordController::class, 'updateFile']);
        Route::delete('{file}', [PhotographicRecordController::class, 'destroyFile']);
        Route::patch('', [PhotographicRecordController::class, 'destroyFiles']);
    });
});

//topics files
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


Route::prefix('registration')->group(function () {

});

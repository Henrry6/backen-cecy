<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyCoursesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('courses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('academic_period_id')
                ->nullable()
                ->comment('Primero, segundo, tercero, cuarto, quinto, sexto, séptimo')
                ->constrained('cecy.catalogues');

            $table->foreignId('area_id')
                ->nullable()
                ->comment('')
                ->constrained('cecy.catalogues');

            $table->foreignId('career_id')
                ->nullable()
                ->comment('El id de la carrera que oferto el curso')
                ->constrained('core.careers');

            $table->foreignId('category_id')
                ->nullable()
                ->comment('Categoría a la cual pertenece el curso, ingles, pedagógico, programación ')
                ->constrained('cecy.catalogues');

            $table->foreignId('certified_type_id')
                ->nullable()
                ->comment('Curso, Taller, Webinar')
                ->constrained('cecy.catalogues');

            $table->foreignId('compliance_indicator_id')
                ->nullable()
                ->comment('Por averigurar campo añadido 21/01')
                ->constrained('cecy.catalogues');

            $table->foreignId('control_id')
                ->nullable()
                ->comment('Por averigurar campo añadido 21/01')
                ->constrained('cecy.catalogues');

            $table->foreignId('course_type_id')
                ->nullable()
                ->comment('Ténico, Administrativo')
                ->constrained('cecy.catalogues');

            $table->foreignId('entity_certification_id')
                ->nullable()
                ->comment('Institución que lo avala, Senecyt, Setec, Setec')
                ->constrained('cecy.catalogues');

            $table->foreignId('formation_type_id')
                ->nullable()
                ->comment('Tipo de capacitación puede ser webinar, taller, curso')
                ->constrained('cecy.catalogues');

            $table->foreignId('frequency_id')
                ->nullable()
                ->comment('Por averigurar campo añadido 21/01')
                ->constrained('cecy.catalogues');

            $table->foreignId('means_verification_id')
                ->nullable()
                ->comment('Por averigurar campo añadido 21/01')
                ->constrained('cecy.catalogues');

            $table->foreignId('modality_id')
                ->nullable()
                ->comment('Presencial, Virtual')
                ->constrained('cecy.catalogues');

            $table->foreignId('responsible_id')
                ->nullable()
                ->comment('Id del docente responsable del curso')
                ->constrained('cecy.instructors');

            $table->foreignId('school_period_id')
                ->nullable()
                ->comment('Periodo lectivo en que se creó el curso')
                ->constrained('cecy.courses');

            $table->foreignId('speciality_id')
                ->nullable()
                ->comment('')
                ->constrained('cecy.catalogues');

            $table->foreignId('state_id')
                ->nullable()
                ->comment('Aprobado, Rechazado, Pendiente')
                ->constrained('cecy.catalogues');

            $table->string('abbreviation')
                ->comment('Abreviación del curso')
                ->nullable();

            $table->string('alignment')
                ->comment('Alineación del curso')
                ->nullable();

            $table->date('approved_at')
                ->comment('Fecha en que se aprobo el curso')
                ->nullable();

            $table->json('bibliographies')
                ->comment('Bibliografías')
                ->nullable();

            $table->string('code')
                ->comment('Código del curso')
                ->nullable();

            $table->double('cost')
                ->comment('Costo del curso')
                ->nullable();

            $table->integer('duration')
                ->comment('Duración medida en horas')
                ->nullable();

            $table->json('evaluation_mechanisms')
                ->comment('Mecanismos de evaluación')
                ->nullable();

            $table->date('expired_at')
                ->comment('Fecha de expiración del curso')
                ->nullable();

            $table->boolean('free')
                ->comment('Si el curso es gratuito es true y si no es false')
                ->nullable();

            $table->string('name')
                ->comment('Nombre del curso')
                ->nullable();

            $table->json('needs')
                ->comment('Necesidades')
                ->nullable();

            $table->date('needed_at')
                ->nullable();

            $table->string('record_number')
                ->nullable()
                ->comment('Número de record');

            $table->json('learning_environments')
                ->comment('Entorno de aprendizaje')
                ->nullable();

            $table->string('local_proposal')
                ->comment('Propuesta local')
                ->nullable();

            $table->string('objective')
                ->comment('Objetivo del curso')
                ->nullable();

            $table->json('observations')
                ->comment('Observación de curso')
                ->nullable();

            $table->integer('practice_hours')
                ->comment('Cantidad de horas practicas del curso')
                ->nullable();

            $table->date('proposed_at')
                ->comment('Fecha en que se propuso el curso')
                ->nullable();

            $table->string('project')
                ->comment('Si el curso persigue generar un proyecto que nombre tiene')
                ->nullable();

            $table->boolean('public')
                ->comment('Si el curso el público o no');

            $table->string('setec_name')
                ->comment('Nombre del setec')
                ->nullable();

            $table->string('summary')
                ->comment('Resumen del curso')
                ->nullable();

            $table->json('target_groups')
                ->comment('Grupo al que va dirigido el curso: niños, jóvenes, adultos')
                ->nullable();

            $table->json('teaching_strategies')
                ->comment('Estrategias de enseñanza')
                ->nullable();

            $table->json('techniques_requisites')
                ->comment('Requisitos técnicos y generales del curso')
                ->nullable();

            $table->integer('theory_hours')
                ->comment('Cantidad de horas del curso en teoria')
                ->nullable();
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('courses');
    }
}

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
                ->nullable()
                ->comment('Alineación del curso');

            $table->date('approved_at')
                ->nullable()
                ->comment('Fecha en que se aprobo el curso');

            $table->json('bibliographies')
                ->nullable()
                ->comment('Bibliografías');

            $table->string('code')
                ->nullable()
                ->comment('Código del curso');

            $table->double('cost')
                ->nullable()
                ->comment('Costo del curso');

            $table->integer('duration')
                ->nullable()
                ->comment('Duración medida en horas');

            $table->json('evaluation_mechanisms')
                ->nullable()
                ->comment('Mecanismos de evaluación');

            $table->date('expired_at')
                ->nullable()
                ->comment('Fecha de expiración del curso');

            $table->boolean('free')
                ->nullable()
                ->comment('Si el curso es gratuito es true y si no es false');

            $table->string('name')
                ->nullable()
                ->comment('Nombre del curso');

            $table->json('needs')
                ->nullable()
                ->comment('Necesidades');

            $table->date('needed_at')
                ->nullable();

            $table->string('record_number')
                ->nullable()
                ->comment('Número de record');

            $table->json('learning_environments')
                ->nullable()
                ->comment('Entorno de aprendizaje');

            $table->string('local_proposal')
                ->nullable()
                ->comment('Propuesta local');

            $table->string('objective')
                ->nullable()
                ->comment('Objetivo del curso');

            $table->json('observations')
                ->nullable()
                ->comment('Observación de curso');

            $table->integer('practice_hours')
                ->nullable()
                ->comment('Cantidad de horas practicas del curso');

            $table->date('proposed_at')
                ->nullable()
                ->comment('Fecha en que se propuso el curso');

            $table->string('project')
                ->comment('Si el curso persigue generar un proyecto que nombre tiene')
                ->nullable();

            $table->boolean('public')
                ->nullable()
                ->comment('Si el curso el público o no');

            $table->string('setec_name')
                ->nullable()
                ->comment('Nombre del setec');

            $table->string('summary')
                ->nullable()
                ->comment('Resumen del curso');

            $table->json('target_groups')
                ->nullable()
                ->comment('Grupo al que va dirigido el curso: niños, jóvenes, adultos');

            $table->json('teaching_strategies')
                ->nullable()
                ->comment('Estrategias de enseñanza');

            $table->json('techniques_requisites')
                ->nullable()
                ->comment('Requisitos técnicos y generales del curso');

            $table->integer('theory_hours')
                ->nullable()
                ->comment('Cantidad de horas del curso en teoria');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('courses');
    }
}

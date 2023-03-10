<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyAdditionalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('additional_informations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('level_instruction_id')
                ->nullable()
                ->comment('Información acerca del nivel de instrucción para el registro')
                ->constrained('cecy.catalogues');

            $table->foreignId('registration_id')
                ->nullable()
                ->comment('Información adicional de trabajo para el registro')
                ->constrained('cecy.registrations');

            $table->text('company_activity')
                ->nullable()
                ->comment('Actividad de la empresa');

            $table->string('company_address')
                ->nullable()
                ->comment('Dirección fisica de la empresa');

            $table->string('company_email')
                ->nullable()
                ->comment('Correo de la empresa');

            $table->string('company_name')
                ->nullable()
                ->comment('Nombre de la empresa');

            $table->string('company_phone')
                ->nullable()
                ->comment('Telefono de la empresa');

            $table->boolean('company_sponsored')
                ->nullable()
                ->comment('La empresa patrocina el curso, true->la empresa patrocina, false-> no patrocina');

            $table->string('contact_name')
                ->nullable()
                ->comment('Nombre de contacto que patrocina');

            $table->json('course_follows')
                ->nullable()
                ->comment('Cursos que te gustaria seguir?');

            $table->json('course_knows')
                ->nullable()
                ->comment('¿Cómo se enteró del curso? Array');

            $table->boolean('worked')
                ->nullable()
                ->comment('El participante trabaja, true -> trabaja, false -> no trabaja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('additional_informations');
    }
}

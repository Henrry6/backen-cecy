<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyAttendancesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('attendances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('detail_planification_id')
                ->constrained('cecy.detail_planifications');

            // Pendiente el tipo de datos si es entero, time
            $table->integer('duration')
                ->comment('Duración de la clase');

            $table->date('registered_at')
                ->comment('Fecha de la asistencia la cual será guardada');

            $table->integer('duration_student')
                ->nullable()
                ->comment('Duracion de horas que asiste el estudiante');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('attendances');
    }
}

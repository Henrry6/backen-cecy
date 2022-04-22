<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyAuthoritiesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('authorities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('institution_id')
                ->nullable()
                ->comment('Una autoridad puede pertenecer a varias instituciones')
                ->constrained('cecy.institutions');

            $table->foreignId('position_id')
                ->nullable()
                ->comment('Cecy, Rector, Vicerrector, Coordinador de carrera, etc.')
                ->constrained('cecy.catalogues');

            $table->foreignId('state_id')
                ->nullable()
                ->comment('Estado de una autoridad, de vacaciones, activo , inactivo, permiso médico')
                ->constrained('cecy.catalogues');

            $table->foreignId('user_id')
                ->comment('Información del usuario')
                ->constrained('authentication.users');

            $table->string('electronic_signature')
                ->nullable()
                ->comment('Código de la firma electrónica');

            $table->date('position_ended_at')
                ->nullable()
                ->comment('Fecha final de la gestión');

            $table->date('position_started_at')
                ->nullable()
                ->comment('Fecha de inicio de la gestión');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('authorities');
    }
}

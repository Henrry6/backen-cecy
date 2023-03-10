<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyDetailSchoolPeriodsTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('detail_school_periods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('school_period_id')
                ->nullable()
                ->comment('Id del periodo escolar')
                ->constrained('cecy.school_periods');

            $table->date('especial_ended_at')
                ->nullable()
                ->comment('Fecha de finalización periodo especial');

            $table->date('especial_started_at')
                ->nullable()
                ->comment('Fecha de inicio periodo especial');

            $table->date('extraordinary_ended_at')
                ->comment('Fecha de finalización periodo extraordinario');

            $table->date('extraordinary_started_at')
                ->comment('Fecha de inicio periodo extraordinario');

            $table->date('nullification_ended_at')
                ->nullable()
                ->comment('Fecha de inicio de anulación de matrícula');

            $table->date('nullification_started_at')
                ->nullable()
                ->comment('Fecha de fin de anulación de matrícula');

            $table->date('ordinary_ended_at')
                ->comment('Fin del periodo ordinario');

            $table->date('ordinary_started_at')
                ->nullable()
                ->comment('Inicio del periodo ordinario');

        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('detail_school_periods');
    }
}

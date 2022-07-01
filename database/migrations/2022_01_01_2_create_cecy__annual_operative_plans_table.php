<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyAnnualOperativePlansTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('annual_operative_plans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->integer('trade_number')
                ->nullable()
                ->comment('Este es el número de oficio para el poa');

            $table->integer('year')
                ->nullable()
                ->comment('El año del poa');

            $table->date('official_date_at')
                ->comment('Fecha en la que se esta realizando el oficio');

            $table->string('activities')
                ->nullable()
                ->comment('actividades al que va dirigido');

        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('annual_operative_plans');
    }
}
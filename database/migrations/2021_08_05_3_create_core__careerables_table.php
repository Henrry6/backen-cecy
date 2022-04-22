<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreCareerablesTable extends Migration
{

    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CORE'))->create('careerables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->morphs('careerable');

            $table->foreignId('career_id')
                ->comment('Carrera')
                ->constrained('core.careers');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CORE'))->dropIfExists('careerables');
    }
}

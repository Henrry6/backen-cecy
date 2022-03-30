<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyCourseProfilesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('course_profiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // Pendiente
            $table->foreignId('course_id')
                ->nullable()
                ->comment('Fk de curso al que se le asigna el perfil del instructor')
                ->constrained('cecy.courses');

            $table->json('required_experiences')
                ->comment('Experiencias del instructor para impartir un curso');

            $table->json('required_knowledges')
                ->comment('Conocimientos del instructor para impartir un curso');

            $table->json('required_skills')
                ->comment('Habilidades del instructor para impartir un curso');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('course_profiles');
    }
}

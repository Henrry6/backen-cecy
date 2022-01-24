<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyProfileInstructorCoursesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('profile_instructor_courses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // Pendiente
            $table->foreignId('course_id')
                ->nullable()
                ->comment('')
                ->constrained('cecy.courses');

            // El nombre debe estar en plural -2
            $table->json('require_experience')
                ->comment('experiencia del instrucotr para impartir un curso');

            // El nombre debe estar en plural -2
            $table->json('require_knowledge')
                ->comment('conocimiento del instructor para impartir un curso');

            $table->json('require_skills')
            ->comment('habilidades del instructor para impartir un curso');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('profile_instructor_courses');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyInstructorCourseProfileTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('instructor_course_profile', function (Blueprint $table) {
            $table->id();

            $table->foreignId('instructor_id')
                ->nullable()
                ->constrained('cecy.instructors');

            $table->foreignId('course_profile_id')
                ->nullable()
                ->constrained('cecy.course_profiles');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('instructor_course_profile');
    }
}

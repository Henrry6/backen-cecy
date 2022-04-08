<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyCourseProfileInstructorTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('course_profile_instructor', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('course_profile_instructor');
    }
}

<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\ProfileInstructorCourse;
use Illuminate\Database\Seeder;

class AuthorizedInstructorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // AuthorizedInstructor::factory()->create();

        $profileInstructorCourses = ProfileInstructorCourse::get();
        $instructors = Instructor::get();

        foreach ($instructors as $instructor) {
            $instructor->profileInstructorCourses()->attach(
                $profileInstructorCourses->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}

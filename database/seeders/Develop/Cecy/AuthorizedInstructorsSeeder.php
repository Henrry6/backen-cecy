<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\CourseProfile;
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

        $courseProfiles = CourseProfile::get();
        $instructors = Instructor::get();

        foreach ($instructors as $instructor) {
            foreach ($courseProfiles as $courseProfile) {
                $instructor->courseProfiles()->attach(
                    $courseProfile->id
                );
            }
        }
    }
}

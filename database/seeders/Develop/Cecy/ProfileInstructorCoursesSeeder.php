<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Course;
use App\Models\Cecy\ProfileInstructorCourse;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileInstructorCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createProfileInstructorCoursesCatalogue();
        $this->createProfileInstructorCourses();
    }

    public function createProfileInstructorCoursesCatalogue()
    {
        //Campos que son de catalogo
    }
    public function createProfileInstructorCourses()
    {

        $faker = Factory::create();

        $courses = Course::get();


        foreach ($courses as $course) {
            ProfileInstructorCourse::factory()->create([
                'course_id' => $course,
                'required_knowledges' => $faker->sentences(),
                'required_experiences' => $faker->sentences(),
                'required_skills' => $faker->sentences(),
            ]);
        }
    }
}

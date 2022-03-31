<?php

namespace Database\Seeders\Develop\Cecy;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Cecy\Course;
use App\Models\Cecy\CourseProfile;

class CourseProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->createCourseProfilesCatalogue();
        $this->createCourseProfiles();
    }

    public function createCourseProfilesCatalogue()
    {
        //Campos que son de catalogo
    }
    public function createCourseProfiles()
    {
        $faker = Factory::create();

        $courses = Course::get();

        foreach ($courses as $course) {
            CourseProfile::factory()->create([
                'course_id' => $course,
                'required_knowledges' => $faker->sentences(),
                'required_experiences' => $faker->sentences(),
                'required_skills' => $faker->sentences(),
            ]);
        }
    }
}

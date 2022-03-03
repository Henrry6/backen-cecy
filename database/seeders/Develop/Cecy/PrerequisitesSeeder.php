<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Course;
use Illuminate\Database\Seeder;
use App\Models\Cecy\Prerequisite;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class PrerequisitesSeeder extends Seeder
{
    public function run()
    {
        Prerequisite::factory(10)->create();

        $faker = Factory::create();
        $courses = Course::get();

        foreach ($courses as $course) {
            for ($i = 0; $i <= 4; $i++) {
                Prerequisite::factory(1)->create([
                    'course_id' => $course,
                    'prerequisite_id' => $faker->randomElement($courses),
                ]);
            }
        }
    }
}

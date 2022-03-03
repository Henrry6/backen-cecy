<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Course;
use Faker\Factory;
use App\Models\Cecy\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $courses = Course::get();


        foreach ($courses as $course) {
            for ($i = 0; $i <= 3; $i++) {
                Topic::factory(1)->create([
                    'course_id' => $course,
                    'parent_id' => null,
                    'level' => 1,
                    'description' => $faker->word()
                ]);
            }
        }

        $topics = Topic::get();

        foreach ($topics as $topic) {
            for ($i = 0; $i <= 2; $i++) {
                Topic::factory(1)->create([
                    'course_id' => null,
                    'parent_id' => $topic,
                    'level' => 2,
                    'description' => $faker->randomElement([
                        'Subtema prueba 1', 'Subtema prueba 2'
                    ]),
                ]);
            }
        }
    }
}

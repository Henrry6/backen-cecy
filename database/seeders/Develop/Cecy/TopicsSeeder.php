<?php

namespace Database\Seeders\Develop\Cecy;

use Faker\Factory;
use App\Models\Cecy\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        Topic::factory(10)->create();

        $topics = Topic::get();

        foreach ($topics as $topic) {
            Topic::factory(2)->create([
                'course_id' => null,
                'parent_id' => $topic['id'],
                'level' => 2,
                'description' => $faker->randomElement([
                    'Subtema prueba 1', 'Subtema prueba 2'
                ]),
            ]);
        }
    }
}

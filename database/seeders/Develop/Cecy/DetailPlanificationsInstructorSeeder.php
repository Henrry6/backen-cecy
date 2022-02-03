<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Topic;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DetailPlanificationsInstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->createDetailPlanificationsInstructorCatalogue();
        $this->createDetailPlanificationsInstructor();
    }

    public function createDetailPlanificationsInstructorCatalogue()
    {
    }

    public function createDetailPlanificationsInstructor()
    {
        $faker = Factory::create();
        $detailPlanifications = DetailPlanification::get();
        $instructors = Instructor::get();
        $topics = Topic::get();

        // foreach ($instructors as $instructor) {
        //     foreach ($detailPlanifications as $detailPlanification) {
        //         $instructor->detailPlanifications()->attach(
        //             $detailPlanification,
        //             ['topic_id' => $faker->randomElement($topics)]
        //         );
        //     }
        // }

        foreach ($instructors as $instructor) {
            $instructor->detailPlanifications()->attach(
                $detailPlanifications->random(rand(1, 3))->pluck('id')->toArray(),
                ['topic_id' => $faker->randomElement($topics)]
            );
        }
    }
}

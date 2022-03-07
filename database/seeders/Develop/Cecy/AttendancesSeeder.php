<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Attendance;
use App\Models\Cecy\DetailPlanification;
use Faker\Factory;
use Illuminate\Database\Seeder;


class AttendancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAttendancesCatalogue();
        $this->createAttendances();
    }

    public function createAttendancesCatalogue()
    {
        //Campos que son de catalogo
    }
    public function createAttendances()
    {
        $faker = Factory::create();
        $detailPlanifications = DetailPlanification::get();

        foreach ($detailPlanifications as $detailPlanification) {
            for ($i = 1; $i <= 30; $i++) {
                Attendance::factory()->create(
                    [
                        'detail_planification_id' => $detailPlanification,
                        'duration' =>  $faker->numberBetween(60, 120),
                        'registered_at' => "2022-03-{$i}"
                    ]
                );
            }
            // $faker->dateTimeBetween('now', '+30 days')
        }
    }
}

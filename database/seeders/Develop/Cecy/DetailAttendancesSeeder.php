<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Attendance;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailAttendance;
use App\Models\Cecy\Registration;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailAttendancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDetailAttendancesCatalogue();
        $this->createDetailAttendances();
    }

    public function createDetailAttendancesCatalogue()
    {
        //Campos que son de catalogo
        //type_id
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory(3)->sequence(
            [
                'code' => $catalogue['attendance']['present'],
                'name' => 'PRESENT',
                'type' => $catalogue['attendance']['type'],
            ],
            [
                'code' => $catalogue['attendance']['backwardness'],
                'name' => 'BACKWARDNESS',
                'type' => $catalogue['attendance']['type'],
            ],
            [
                'code' => $catalogue['attendance']['absent'],
                'name' => 'ABSENT',
                'type' => $catalogue['attendance']['type'],
            ],
        )->create();
    }
    public function createDetailAttendances()
    {
        $types = Catalogue::where('type', 'ATTENDANCE')->get();
        $faker = Factory::create();
        $attendances  = Attendance::get();
        foreach ($attendances as $attendance) {
            $attendanceDate = strtotime($attendance->registered_at);
            $dateNow = strtotime(date('y-m-d'));
            if ($attendanceDate >= $dateNow) {
                DetailAttendance::factory()->create(
                    [
                        'attendance_id' => $attendance,
                        'type_id' => null
                    ]
                );
            } else {
                DetailAttendance::factory()->create(
                    [
                        'attendance_id' => $attendance,
                        'type_id' => $faker->randomElement($types)
                    ]
                );
            }
        }
    }
}

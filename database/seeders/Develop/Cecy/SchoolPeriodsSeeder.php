<?php

namespace Database\Seeders\Develop\Cecy;

use Illuminate\Database\Seeder;
use App\Models\Cecy\SchoolPeriod;
use App\Models\Cecy\Catalogue;
use App\Models\Core\State;
use Illuminate\Support\Facades\DB;

class SchoolPeriodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSchoolPeriodsCatalogue();
        $this->createSchoolPeriods();
    }

    public function createSchoolPeriodsCatalogue()
    {

        //state_id (hecho)
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory()->sequence(
            [
                'code' => State::CURRENT,
                'name' => 'CURRENT',
                'type' => $catalogues['school_period_state']['type'],
                'description' => 'Estado de periodo académico',
            ],
            [
                'code' => State::HISTORICAL,
                'name' => 'HISTORICAL',
                'type' => $catalogues['school_period_state']['type'],
                'description' => 'Estado de periodo académico',
            ],

        )->create();
    }
    public function createSchoolPeriods()
    {
        $current = Catalogue::where('code', State::CURRENT)->first();
        $historical = Catalogue::where('code', State::HISTORICAL)->first();

        SchoolPeriod::factory(2)->sequence(
            [
                'code' => '2021-1',
                'ended_at' => '2021-06-01',
                'minimum_note' => 70,
                'name' => 'ENERO 2021 - JUNIO 2021',
                'started_at' => '2021-01-01',
                'state_id' => $historical,
            ],
            [
                'code' => '2021-2',
                'ended_at' => '2022-05-01',
                'minimum_note' => 70,
                'name' => 'DICIEMBRE 2021 - MAYO 2022',
                'started_at' => '2021-12-01',
                'state_id' => $current,
            ]
        )->create();
    }
}

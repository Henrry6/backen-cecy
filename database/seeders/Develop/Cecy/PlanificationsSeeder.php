<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Authority;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailSchoolPeriod;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Planification;
use App\Models\Core\State;
use Illuminate\Database\Seeder;
use Faker\Factory;

class PlanificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPlanificationsCatalogue();
        $this->createPlanifications();
    }

    public function createPlanificationsCatalogue()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        Catalogue::factory(6)->sequence(
            [
                'code' => State::TO_BE_APPROVED,
                'name' => 'POR APROBADO',
                'type' => $catalogue['planification_state']['type'],
                'description' => 'Falta poner una descripción'
            ],
            [
                'code' => State::COMPLETED,
                'name' => 'COMPLETADO',
                'type' => $catalogue['planification_state']['type'],
                'description' => 'Falta poner una descripción'
            ],
            [
                'code' => State::IN_PROCESS,
                'name' => 'EN PROCESO',
                'type' => $catalogue['planification_state']['type'],
                'description' => 'Falta poner una descripción'
            ],
            [
                'code' => State::NOT_APPROVED,
                'name' => 'NO APROBADO',
                'type' => $catalogue['planification_state']['type'],
                'description' => 'Falta poner una descripción'
            ],
            [
                'code' => State::APPROVED,
                'name' => 'APROBADO',
                'type' => $catalogue['planification_state']['type'],
                'description' => 'Falta poner una descripción'
            ],
            [
                'code' => State::CULMINATED,
                'name' => 'CULMINADO',
                'type' => $catalogue['planification_state']['type'],
                'description' => 'Falta poner una descripción'
            ],

        )->create();
    }
    public function createPlanifications()
    {
        $faker = Factory::create();
        $courses = Course::get();
        $states = Catalogue::where('type', 'PLANIFICATION_STATE')->get();

        $cecy = Catalogue::where('code', 'CECY')->first();
        $ocs = Catalogue::where('code', 'REPRESENTATIVE_OCS')->first();

        $vicerectorposition = Catalogue::where('code', 'VICERECTOR')->first();
        $responsableCecy = Authority::where('position_id', $cecy->id)->first();
        $responsableOcs = Authority::where('position_id', $ocs->id)->first();
        $vicerector = Authority::where('position_id', $vicerectorposition->id)->first();
        $responsablesCourse = Instructor::get();
        $detailSchoolPeriods = DetailSchoolPeriod::get();

        for ($i = 0; $i <= 29; $i++) {

            Planification::factory()->create(
                [
                    'course_id' => $courses[$i],
                    'detail_school_period_id' =>  $faker->randomElement($detailSchoolPeriods),
                    'vicerector_id' => $vicerector,
                    'responsible_course_id' => $responsablesCourse[rand(0, sizeof($responsablesCourse) - 1)],
                    'responsible_ocs_id' => $responsableOcs,
                    'responsible_cecy_id' => $responsableCecy,
                    'state_id' => 77,
                    'approved_at' => $faker->date('Y-m-d'),
                    'code' => $faker->word(),
                    'ended_at' => $faker->dateTimeBetween('+2 months', '+3 months')->format('Y-m-d'),
                    'needs' => $faker->sentences(),
                    'observations' => $faker->sentences(),
                    'started_at' => $faker->dateTimeBetween('-1 months', '+1 months')->format('Y-m-d'),
                ]
            );
        }
    }
}

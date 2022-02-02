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

        Catalogue::factory()->sequence(
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
            ]
        )->create();
    }
    public function createPlanifications()
    {
        $faker = Factory::create();
        $courses = Course::get();
        $culminatedState = Catalogue::where('code', State::CULMINATED)->first();
        $approvedState = Catalogue::where('code', State::APPROVED)->first();
        $cecy = Catalogue::where('code', 'CECY')->first();
        $ocs = Catalogue::where('code', 'REPRESENTATIVE_OCS')->first();
        $vicerectorposition = Catalogue::where('code', 'VICERECTOR')->first();
        $responsableCecy = Authority::where('position_id', $cecy->id)->first();
        $responsableOcs = Authority::where('position_id', $ocs->id)->first();
        $vicerector = Authority::where('position_id', $vicerectorposition->id)->first();
        $responsablesCourse = Instructor::get();
        $detailSchoolPeriods = DetailSchoolPeriod::get();

        for ($i = 1; $i < 6; $i++) {
            $schoolPeriod = $detailSchoolPeriods[$i]->schoolPeriod()->first();
            $state = $schoolPeriod->state()->first();
            $planificationState =  $approvedState;

            if ($state->code === State::HISTORICAL) {
                $planificationState =  $culminatedState;
            }

            Planification::factory()->create(
                [
                    'course_id' => ($courses[$i])->id,
                    'detail_school_period_id' => ($detailSchoolPeriods[$i])->id,
                    'vicerector_id' => $vicerector->id,
                    'responsible_course_id' => ($responsablesCourse[rand(0, sizeof($responsablesCourse) - 1)])->id,
                    'responsible_ocs_id' => $responsableOcs->id,
                    'responsible_cecy_id' => $responsableCecy->id,
                    'state_id' => $planificationState->id,
                    'approved_at' => $faker->date(),
                    'code' => $faker->word(),
                    'ended_at' => $faker->date('+2 months', '+3 months'),
                    'needs' => $faker->sentences(),
                    'observations' => $faker->sentences(),
                    'started_at' => $faker->dateTimeBetween('-1 months', '+1 months'),
                ]
            )->create();
        }
    }
}

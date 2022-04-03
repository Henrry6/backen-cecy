<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Classroom;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Planification;
use App\Models\Core\State;
use Illuminate\Database\Seeder;
use Faker\Factory;

class DetailPlanificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDetailPlanificationsCatalogue();
        $this->createDetailPlanifications();
    }

    public function createDetailPlanificationsCatalogue()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        //workdays
        Catalogue::factory(14)->sequence(
            [
                'code' => $catalogue['workday']['evening'],
                'name' => 'VESPERTINA',
                'type' => $catalogue['workday']['type'],
                'description' => 'Jornada del paralelo'
            ],
            [
                'code' => $catalogue['workday']['morning'],
                'name' => 'MATUTINA',
                'type' => $catalogue['workday']['type'],
                'description' => 'Jornada del paralelo'
            ],
            [
                'code' => $catalogue['workday']['nocturnal'],
                'name' => 'NOCTURNA',
                'type' => $catalogue['workday']['type'],
                'description' => 'Jornada del paralelo'
            ],
            //parallels
            [
                'code' => $catalogue['parallel_name']['a'],
                'name' => 'A',
                'type' => $catalogue['parallel_name']['type'],
                'description' => 'Paralelo de un detalle de planificación'
            ],
            [
                'code' => $catalogue['parallel_name']['b'],
                'name' => 'B',
                'type' => $catalogue['parallel_name']['type'],
                'description' => 'Paralelo de un detalle de planificación'

            ],
            [
                'code' => $catalogue['parallel_name']['c'],
                'name' => 'C',
                'type' => $catalogue['parallel_name']['type'],
                'description' => 'Paralelo de un detalle de planificación'

            ],
            [
                'code' => $catalogue['parallel_name']['d'],
                'name' => 'D',
                'type' => $catalogue['parallel_name']['type'],
                'description' => 'Paralelo de un detalle de planificación'

            ],
            [
                'code' => $catalogue['parallel_name']['e'],
                'name' => 'E',
                'type' => $catalogue['parallel_name']['type'],
                'description' => 'Paralelo de un detalle de planificación'

            ],
            //days
            [
                'code' => $catalogue['day']['monday_friday'],
                'name' => 'LUNES A VIERNES',
                'type' => $catalogue['day']['type'],
                'description' => 'Días en que se lleva a cabo un paralelo'
            ],
            [
                'code' => $catalogue['day']['monday_sunday'],
                'name' => 'LUNES A DOMINGO',
                'type' => $catalogue['day']['type'],
                'description' => 'Días en que se lleva a cabo un paralelo'
            ],
            [
                'code' => $catalogue['day']['sundays'],
                'name' => 'DOMINGOS',
                'type' => $catalogue['day']['type'],
                'description' => 'Días en que se lleva a cabo un paralelo'
            ],
            [
                'code' => $catalogue['day']['saturdays'],
                'name' => 'SABADOS',
                'type' => $catalogue['day']['type'],
                'description' => 'Días en que se lleva a cabo un paralelo'
            ],
            //detail_planification_states
            [
                'code' => State::TO_BE_APPROVED,
                'name' => 'POR APROBAR',
                'type' => $catalogue['detail_planification_state']['type'],
                'description' => 'Estado de detalle de planificación'
            ],
            [
                'code' => State::CULMINATED,
                'name' => 'CULMINADO',
                'type' => $catalogue['detail_planification_state']['type'],
                'description' => 'Estado de detalle de planificación'
            ],
            [
                'code' => State::IN_PROCESS,
                'name' => 'EN PROCESO',
                'type' => $catalogue['detail_planification_state']['type'],
                'description' => 'Estado de detalle de planificación'
            ],
            [
                'code' => State::NOT_APPROVED,
                'name' => 'NO APROBADO',
                'type' => $catalogue['detail_planification_state']['type'],
                'description' => 'Estado de detalle de planificación'
            ],
            [
                'code' => State::APPROVED,
                'name' => 'APROBADO',
                'type' => $catalogue['detail_planification_state']['type'],
                'description' => 'Estado de detalle de planificación'
            ]
        )->create();
    }
    public function createDetailPlanifications()
    {
        $faker = Factory::create();
        $classrooms = Classroom::all();
        $days = Catalogue::where('type', 'DAY')->get();
        $workdays = Catalogue::where('type', 'WORKDAY')->get();
        $parallels = Catalogue::where('type', 'PARALLEL_NAME')->get();
        $states = Catalogue::where('type', 'DETAIL_PLANIFICATION_STATE')->get();
        $planifications = Planification::all();
        $iterator = 0;

        foreach ($planifications as $planification) {
            for ($i = 0; $i <= 1; $i++) {
                DetailPlanification::factory()->create(
                    [
                        'classroom_id' => $classrooms[$iterator],
                        'day_id' => $days[rand(0, sizeof($days) - 1)],
                        'parallel_id' => $parallels[rand(0, sizeof($parallels) - 1)],
                        'planification_id' => $planification,
                        'workday_id' => $workdays[rand(0, sizeof($workdays) - 1)],
                        'state_id' => $faker->randomElement($states),
                        'ended_time' => $faker->time(),
                        'observation' => $faker->sentence(),
                        'plan_ended_at' => $faker->date('Y_m_d'),
                        'registrations_left' => $faker->randomDigit(),
                        'started_time' => $faker->time()
                    ]
                );
                $iterator = $iterator + 1;
            }
        }
    }
}

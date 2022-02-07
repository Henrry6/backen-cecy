<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Authentication\User;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Participant;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ParticipantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createParticipantCatalogue();
        $this->createParticipants();
    }

    public function createParticipantCatalogue()
    {
        //Campos que son de catalogo
        //type_id
        //state_id
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory(10)->sequence(
            [
                'code' => $catalogue['participant_state']['approved'],
                'name' => 'Aprobado',
                'type' => $catalogue['participant_state']['type'],
                'description' => 'Estado del estudiante de aprobado en el curso'
            ],
            [
                'code' => $catalogue['participant_state']['not_approved'],
                'name' => 'Reprobado',
                'type' => $catalogue['participant_state']['type'],
                'description' => 'Estado del estudiante cuando esta esperando ser aprobado'
            ],
            [
                'code' => $catalogue['participant_state']['to_be_approved'],
                'name' => 'Por aprobar',
                'type' => $catalogue['participant_state']['type'],
                'description' => 'Estado del estudiante de reprobado en el curso'
            ]
        )->create();
    }

    public function createParticipants()
    {
        $faker = Factory::create();

        $states = Catalogue::where('type', 'PARTICIPANT_STATE')->get();
        $types = Catalogue::where('type', 'PARTICIPANT')->get();
        $users = User::where('id', '>=', 36)->where('id', '<=', 85)->get();

        foreach ($users  as $user) {
            Participant::factory()->create(
                [
                    'state_id' => $faker->randomElement($states),
                    'type_id' => $faker->randomElement($types),
                    'user_id' => $user->id
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders\Cecy;

use App\Models\Cecy\Catalogue;
use Illuminate\Database\Seeder;

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
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory()->sequence(
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
    }
}

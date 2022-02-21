<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Classroom;
use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;

class ClassroomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CREAR AQUI LAS SEMILLAS PARA ClLASSROOMS

        $this->createClassroomsCatalogue();
        $this->createClassrooms();
    }
    public function createClassroomsCatalogue()
    {
        //Campos que son de catalogo
        //type_id
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory(3)->sequence(
            [
                'code' => $catalogue['classroom']['office'],
                'name' => 'Oficina',
                'type' => $catalogue['classroom']['type'],
                'description' => 'Tipo de aula de clase de oficina'
            ],
            [
                'code' => $catalogue['classroom']['classroom_class'],
                'name' => 'Aula de clase presencial',
                'type' => $catalogue['classroom']['type'],
                'description' => 'Tipo de aula de clase aula de clase presencial'
            ],
            [
                'code' => $catalogue['classroom']['laboratory'],
                'name' => 'Laboratorio',
                'type' => $catalogue['classroom']['type'],
                'description' => 'Tipo de aula de clase laboratorio'
            ],
        )->create();
    }

    public function createClassrooms()
    {
        Classroom::factory(60)->create();
    }
}

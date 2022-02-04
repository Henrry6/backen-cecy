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
        // echo (Catalogue::where('type', 'CLASSROOM')->get());
    }

    public function createClassrooms()
    {
        Classroom::factory(10)->create();

        // DB::select("insert into cecy.classroom(state_id, description, capacity, code, name)VALUES('','Este aula esta en el edificio del Yavirac','40','A001','Aula1')");
        // DB::select("insert into cecy.classroom(state_id, description, capacity, code, name)VALUES('','Este aula esta en el cenepa','20','A002','Aula2')");
        // DB::select("insert into cecy.classroom(state_id, description, capacity, code, name)VALUES('','Este laboratorio esta en el cenepa','30','L001','Laboratorio1')");
        // DB::select("insert into cecy.classroom(state_id, description, capacity, code, name)VALUES('','Este laboratorio esta en el cenepa','20','L002','Laboratorio2')");
        // DB::select("insert into cecy.classroom(state_id, description, capacity, code, name)VALUES('','Este aula esta en el edificio del Yavirac','10','A003','Aula3')");
        // DB::select("insert into cecy.classroom(state_id, description, capacity, code, name)VALUES('','Este aula esta en el edificio del Yavirac','80','A004','Aula4')");
        // DB::select("insert into cecy.classroom(state_id, description, capacity, code, name)VALUES('','Este laboratorio esta en el edificio del Yavirac','20','L003','Laboratorio3')");
        // DB::select("insert into cecy.classroom(state_id, description, capacity, code, name)VALUES('','Este laboratorio esta en el edificio del Yavirac','10','L004','Laboratorio4')");
        // DB::select("insert into cecy.classroom(state_id, description, capacity, code, name)VALUES('','Esta oficina esta en el edificio del Yavirac','30','O001','Oficina1')");
        // DB::select("insert into cecy.classroom(state_id, description, capacity, code, name)VALUES('','Esta oficina esta en el edificio del Yavirac','30','O002','Oficina2')");
    }
}

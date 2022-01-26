<?php

namespace Database\Seeders\Cecy;

use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Instructor;
use Illuminate\Database\Seeder;

class DetailPlanificationsInstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->createDetailPlanificationsInstructorCatalogue();
        $this->createDetailPlanificationsInstructor();
    }

    public function createDetailPlanificationsInstructorCatalogue()
    {
        //Campos que son de catalogo
    }
    public function createDetailPlanificationsInstructor()
    {
        //CREAR AQUI LAS SEMILLAS PARA DETAILPLANIFICATIONS
        /* Instructor::factory(10)->create();
        DetailPlanification::factory(10)->create();
        $Instructors= Instructor::get();
        $DetailPlanifications= DetailPlanification::get();


        DetailPlanificationsInstructor::factory(10)->create(
            [
                'detail_planification_id'=>$DetailPlanifications[rand(0, $DetailPlanifications->count()-1)],
                'Instructors'=>$Instructors[rand(0, $Instructors->count()-1)],

            ]
        ); */
    }
}

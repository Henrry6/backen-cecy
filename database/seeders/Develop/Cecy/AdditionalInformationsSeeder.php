<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\AdditionalInformation;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Registration;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AdditionalInformationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdditionalInformationsCatalogue();
        $this->createAdditionalInformations();
    }

    public function createAdditionalInformationsCatalogue()
    {
        //Campos que son de catalogo
        //level_instruction_id

        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        //type_id
        Catalogue::factory()->sequence(
            [
                'code' => $catalogue['level_instruction']['primary'],
                'name' => 'Primaria',
                'type' => $catalogue['level_instruction']['type'],
                'description' => 'Cuando el nivel de instrucción del participante es de Primaria'
            ],
            [
                'code' => $catalogue['level_instruction']['secondary'],
                'name' => 'Secundaria',
                'type' => $catalogue['level_instruction']['type'],
                'description' => 'Cuando el nivel de instrucción del participante es de Secundaria'
            ],
            [
                'code' => $catalogue['level_instruction']['undergraduate'],
                'name' => 'Pregrado',
                'type' => $catalogue['level_instruction']['type'],
                'description' => 'Cuando el nivel de instrucción del participante es de Pregrado'
            ],
            [
                'code' => $catalogue['level_instruction']['mastery'],
                'name' => 'Maestría',
                'type' => $catalogue['level_instruction']['type'],
                'description' => 'Cuando el nivel de instrucción del participante es de Maestría'
            ],
            [
                'code' => $catalogue['level_instruction']['doctorate'],
                'name' => 'Doctorado',
                'type' => $catalogue['level_instruction']['type'],
                'description' => 'Cuando el nivel de instrucción del participante es de Doctorado'
            ],
        )->create();
    }
    public function createAdditionalInformations()
    {
        $faker = Factory::create();

        $levelInstructions = Catalogue::where('type', 'LEVEL_INSTRUCTION')->get();
        $registrations = Registration::get();


        foreach ($registrations as $registration) {
            AdditionalInformation::factory()->create([
                'level_instruction_id' => $faker->randomElement($levelInstructions),
                'registration_id' => $registration,
                'company_activity' => $faker->name(),
                'company_address' => $faker->address(),
                'company_email' => $faker->email(),
                'company_name' => $faker->name(),
                'company_phone' => $faker->phoneNumber(),
                'company_sponsored' => $faker->boolean(),
                'contact_name' => $faker->name(),
                'course_follows' =>  $faker->sentences(),
                'course_knows' => $faker->sentences(),
                'worked' => $faker->boolean()
            ]);
        }
    }
}

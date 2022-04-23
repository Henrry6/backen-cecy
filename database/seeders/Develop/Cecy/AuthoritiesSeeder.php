<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Authority;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Institution;
use App\Models\Core\Career;
use Faker\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class AuthoritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAuthoritiesCatalogue();
        $this->createAuthorities();
        $this->createCareerables();
    }

    public function createAuthoritiesCatalogue()
    {
        //Campos que son de catalogo
        //state_id
        //position_id
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory(10)->sequence(
            [
                'code' => $catalogue['authority_state']['on_vocation'],
                'name' => 'Vacaciones',
                'type' => $catalogue['authority_state']['type'],
                'description' => 'Cuando una autoridad se encuentra de vacaciones'
            ],
            [
                'code' => $catalogue['authority_state']['medical_consent'],
                'name' => 'Permiso médico',
                'type' => $catalogue['authority_state']['type'],
                'description' => 'Cuando una autoridad se encuentra con permiso médico'
            ],
            [
                'code' => $catalogue['authority_state']['active'],
                'name' => 'Activo',
                'type' => $catalogue['authority_state']['type'],
                'description' => 'Cuando una autoridad se encuentra actualmente activa'
            ],
            [
                'code' => $catalogue['authority_state']['inactive'],
                'name' => 'Inactivo',
                'type' => $catalogue['authority_state']['type'],
                'description' => 'Cuando una autoridad se encuentra actualmente inactiva'
            ],
            [
                'code' => $catalogue['position']['rector'],
                'name' => 'Rector',
                'type' => $catalogue['position']['type'],
                'description' => 'Cuando la autoridad es el Rector'
            ],
            [
                'code' => $catalogue['position']['vicerector'],
                'name' => 'Vicerector',
                'type' => $catalogue['position']['type'],
                'description' => 'Cuando la autoridad es el Vicerrector'
            ],
            [
                'code' => $catalogue['position']['representative_ocs'],
                'name' => 'Represetante OCS',
                'type' => $catalogue['position']['type'],
                'description' => 'Cuando la autoridad es el representante del OCS'
            ],
            [
                'code' => $catalogue['position']['logistics'],
                'name' => 'Logistica',
                'type' => $catalogue['position']['type'],
                'description' => 'Cuando la autoridad es parte de logística'
            ],
            [
                'code' => $catalogue['position']['cecy'],
                'name' => 'Cecy',
                'type' => $catalogue['position']['type'],
                'description' => 'Cuando la autoridad es el reponsable del CECY'
            ],
            [
                'code' => $catalogue['position']['career_coordinator'],
                'name' => 'Coordinador de carrera',
                'type' => $catalogue['position']['type'],
                'description' => 'Cuando la autoridad es el coordinador de carrera'
            ]
        )->create();
    }

    public function createAuthorities()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $faker = Factory::create();

        $institutions = Institution::get();
        $positionRector = Catalogue::firstWhere('code', $catalogue['position']['rector']);
        $positionVicerector = Catalogue::firstWhere('code', $catalogue['position']['vicerector']);
        $positionRepresentativeOcs = Catalogue::firstWhere('code', $catalogue['position']['representative_ocs']);
        $positionCecy = Catalogue::firstWhere('code', $catalogue['position']['cecy']);
        $positionCareerCoordinator = Catalogue::firstWhere('code', $catalogue['position']['career_coordinator']);
        $state = Catalogue::firstWhere('code', $catalogue['authority_state']['active']);

        Authority::factory(5)->sequence(
            [
                'institution_id' => $faker->randomElement($institutions),
                'position_id' => $positionRector,
                'state_id' => $state,
                'user_id' => 2,
                'position_started_at' => $faker->dateTime->format('Y-m-d H:i:s'),
                'position_ended_at' => $faker->dateTimeBetween('+2 months', '+3 months')->format('Y-m-d H:i:s'),
                'electronic_signature' => $faker->text($maxNbChars = 50)
            ],
            [
                'institution_id' => $faker->randomElement($institutions),
                'position_id' => $positionVicerector,
                'state_id' => $state,
                'user_id' => 3,
                'position_started_at' => $faker->dateTimeBetween('-1 months', '+1 months')->format('Y-m-d H:i:s'),
                'position_ended_at' => $faker->dateTimeBetween('+2 months', '+3 months')->format('Y-m-d H:i:s'),
                'electronic_signature' => $faker->text($maxNbChars = 50)
            ],
            [
                'institution_id' => $faker->randomElement($institutions),
                'position_id' => $positionRepresentativeOcs,
                'state_id' => $state,
                'user_id' => 4,
                'position_started_at' => $faker->dateTimeBetween('-1 months', '+1 months')->format('Y-m-d H:i:s'),
                'position_ended_at' => $faker->dateTimeBetween('+2 months', '+3 months')->format('Y-m-d H:i:s'),
                'electronic_signature' => $faker->text($maxNbChars = 50)
            ],
            [
                'institution_id' => $faker->randomElement($institutions),
                'position_id' => $positionCecy,
                'state_id' => $state,
                'user_id' => 5,
                'position_started_at' => $faker->dateTimeBetween('-1 months', '+1 months')->format('Y-m-d H:i:s'),
                'position_ended_at' => $faker->dateTimeBetween('+2 months', '+3 months')->format('Y-m-d H:i:s'),
                'electronic_signature' => $faker->text($maxNbChars = 50)
            ],
            [
                'institution_id' => $faker->randomElement($institutions),
                'position_id' => $positionCareerCoordinator,
                'state_id' => $state,
                'user_id' => 6,
                'position_started_at' => $faker->dateTimeBetween('-1 months', '+1 months')->format('Y-m-d H:i:s'),
                'position_ended_at' => $faker->dateTimeBetween('+2 months', '+3 months')->format('Y-m-d H:i:s'),
                'electronic_signature' => $faker->text($maxNbChars = 50)
            ],
        )->create();
    }
    
    public function createCareerables()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);

        $careerCoordinator = Authority::whereHas('position', function (Builder $query) use ($catalogue) {
            $query->where('code', $catalogue['position']['career_coordinator']);
        })->first();

        $careers = Career::get();

        for ($i = 0; $i <= 1; $i++) {
            $careerCoordinator->careers()->attach(($careers[$i])->id);
        }
    }
}

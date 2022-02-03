<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Registration;
use App\Models\Cecy\RegistrationRequirement;
use App\Models\Cecy\Requirement;
use Illuminate\Database\Seeder;

class RegistrationRequerimentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRegistrationRequerimentsCatalogue();
        $this->createRegistrationRequeriments();
    }

    public function createRegistrationRequerimentsCatalogue()
    {
        //Campos que son de catalogo
    }
    public function createRegistrationRequeriments()
    {
        $registrations = Registration::get();
        $requirements = Requirement::get();

        //por cada registro le asigno entre 1 a 3 requerimientos

        foreach ($registrations as $registration) {
            $registration->requirements()->attach(
                $requirements->random(rand(1, 3))->pluck('id')->toArray(),
                ['url' => '/server/etc/images']
            );
        }

        // foreach ($registrations as $registration) {
        //     $registration
        //         ->attach(
        //             $requirements,
        //             // ['url' => '/server/etc/images']
        //         )
        //         ->create();
        // }

        // $roles = Role::factory()->count(3)->create();

        // $user = User::factory()
        //     ->count(3)
        //     ->hasAttached($roles, ['active' => true])
        //     ->create();
        // foreach ($registrations as $registration) {
        //     $registration->requirements()->attach([
        //         1,
        //         2,
        //         3,
        //     ]);
        // }
    }
}

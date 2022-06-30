<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\CourseProfile;
use App\Models\Cecy\Instructor;
use Illuminate\Database\Seeder;
use Faker\Factory;


class AuthorizedInstructorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $courseProfiles = CourseProfile::get();
        $instructors = Instructor::get();

        foreach ($courseProfiles as $courseProfile) {
            for ($i = 0; $i < 5; $i++) {
                $instructor = $faker->randomElement($instructors);
                $instructor->courseProfiles()->attach(
                    $courseProfile->id,
                    [
                        'instructor_id' => $instructor->id,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }
}

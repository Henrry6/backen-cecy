<?php

namespace Database\Seeders\Develop\Cecy;

use Illuminate\Database\Seeder;
use App\Models\Cecy\Prerequisite;
use Illuminate\Support\Facades\DB;

class PrerequisitesSeeder extends Seeder
{
    public function run()
    {
        Prerequisite::factory(10)->create();
        // DB::table('prerequisites')->insert(
        //     [
        //         'course_id' => 1,
        //         'prerequisite_id' => 2,
        //     ],
        //     [
        //         'course_id' => 1,
        //         'prerequisite_id' => 3,
        //     ],
        //     [
        //         'course_id' => 1,
        //         'prerequisite_id' => 4,
        //     ],
        //     [
        //         'course_id' => 2,
        //         'prerequisite_id' => 1,
        //     ],
        //     [
        //         'course_id' => 2,
        //         'prerequisite_id' => 3,
        //     ],
        //     [
        //         'course_id' => 2,
        //         'prerequisite_id' => 5,
        //     ],
        // );
    }
}

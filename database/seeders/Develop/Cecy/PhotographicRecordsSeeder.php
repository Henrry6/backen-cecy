<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\PhotographicRecord;
use Illuminate\Database\Seeder;

class PhotographicRecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhotographicRecord::factory(20)->create();
    }

}

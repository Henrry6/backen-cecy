<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\AnnualOperativePlan;
use App\Models\Cecy\PhotographicRecord;
use Illuminate\Database\Seeder;

class AnnualOperativePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnnualOperativePlan::factory(50)->create();
    }

}

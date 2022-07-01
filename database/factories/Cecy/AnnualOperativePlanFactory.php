<?php

namespace Database\Factories\Cecy;

use App\Models\Cecy\AnnualOperativePlan;
use App\Models\Cecy\Attendance;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailAttendance;
use App\Models\Cecy\Planification;
use App\Models\Cecy\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnualOperativePlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnnualOperativePlan::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [

            'trade_number'=> $this->faker->numberBetween(1,20),
            'year'=> $this->faker->numberBetween(2019,2022),
            'official_date_at'=> $this->faker->date(),
            'activities'=>$this->faker->word()
        ];
    }
}

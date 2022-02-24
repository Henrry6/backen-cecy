<?php

namespace Database\Factories\Cecy;

use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\PhotographicRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotographicRecordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PhotographicRecord::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $detail = DetailPlanification::get();

        return [
            'detail_planification_id' => $detail[rand(0, sizeof($detail) - 1)],
            'description' =>$this->faker->word(),
            'number_week' => $this->faker->numberBetween(1,4),
            'url_image' => $this->faker->word(),
            'week_at' => $this->faker->date(),
        ];
    }
}

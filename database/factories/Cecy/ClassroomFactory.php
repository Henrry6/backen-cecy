<?php

namespace Database\Factories\Cecy;

use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassroomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classroom::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $types =  Catalogue::where('type', 'CLASSROOM')->get();
        return [
            'type_id' =>  $this->faker->randomElement($types),
            'description' => $this->faker->text(),
            'capacity' => $this->faker->randomElement(['10', '40']),
            'code' => $this->faker->text($maxNbChars = 50),
            'name' => $this->faker->text($maxNbChars = 50)
        ];
    }
}

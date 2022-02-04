<?php

namespace Database\Factories\Cecy;

use App\Models\Cecy\Prerequisite;
use App\Models\Cecy\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrerequisiteFactory extends Factory
{
    protected $model = Prerequisite::class;

    public function definition()
    {
        $course = Course::get();

        return [
            'course_id' => $this->faker->randomElement($course),
            'prerequisite_id' => $this->faker->randomElement($course),
        ];
    }
}

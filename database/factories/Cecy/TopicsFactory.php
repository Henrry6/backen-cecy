<?php

namespace Database\Factories\Cecy;

use App\Models\Cecy\Topic;
use App\Models\Cecy\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicsFactory extends Factory
{
    protected $model = Topic::class;
    
    public function definition()
    {
        $course = Course::get();

        return [
            'course_id' => $this->faker->randomElement($course[rand(0, sizeof($course) - 1)]),
            'parent_id' => $this->faker->randomElement(null, $course[rand(0, sizeof($course) - 1)]),
            'level' => $this->faker->randomElement(1, 2),
            'description' => $this->faker->words(3),
        ];
    }
}

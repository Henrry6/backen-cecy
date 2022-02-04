<?php

namespace Database\Factories\Cecy;

use App\Models\Cecy\Topic;
use App\Models\Cecy\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition()
    {
        $courses = Course::get();
        $topics = Topic::get();

        return [
            'course_id' => $this->faker->randomElement($courses),
            'parent_id' => $this->faker->randomElement(null, $topics),
            'level' => $this->faker->randomElement([1, 2]),
            'description' => $this->faker->word(),
        ];
    }
}

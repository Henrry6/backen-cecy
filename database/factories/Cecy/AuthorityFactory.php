<?php

namespace Database\Factories\Cecy;

use App\Models\Cecy\Authority;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\ProfileInstructorCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Authority::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {

        return [];
    }
}

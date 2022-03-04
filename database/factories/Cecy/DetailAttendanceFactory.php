<?php

namespace Database\Factories\Cecy;

use App\Models\Cecy\Attendance;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailAttendance;
use App\Models\Cecy\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailAttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetailAttendance::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $registration = Registration::get();
        $attendance = Attendance::get();
        $types = Catalogue::where('type', $catalogue['attendance']['type'])->get();


        return [
            'attendance_id' => $this->faker->randomElement($attendance),
            'registration_id' => $this->faker->randomElement($registration),
            'type_id' => $this->faker->randomElement($types),
        ];
    }
}

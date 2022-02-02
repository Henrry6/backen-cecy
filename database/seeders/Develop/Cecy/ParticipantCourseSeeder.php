<?php

namespace Database\Seeders\Develop\Cecy;

use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use Illuminate\Database\Seeder;

class ParticipantCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createParticipantCourseCatalogue();
        $this->createParticipantCourse();
    }

    public function createParticipantCourseCatalogue()
    {
        //Campos que son de catalogo
    }
    public function createParticipantCourse()
    {
        $participant_types = Catalogue::where('type', 'PARTICIPANT')->get();
        $courses = Course::get();
        //por cada curso le asigno entre 1 a 3 tipo de participante

        foreach ($courses as $course) {
            $course->catalogues()->attach(
                $participant_types->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}

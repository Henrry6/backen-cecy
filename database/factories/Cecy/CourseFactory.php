<?php

namespace Database\Factories\Cecy;

use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\Instructor;
use App\Models\Core\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        $academicPeriods = Catalogue::where('type', $catalogue['academic_period']['type'])->get();
        // $areas = Catalogue::where('type', $catalogue['area']['type'])->get();
        $entityCertification = Catalogue::where('type', $catalogue['entity_certification']['type'])->get();
        $career = Career::get();
        $responsible = Instructor::get();
        $category = Catalogue::where('type', $catalogue['category']['type'])->get();
        $formationType = Catalogue::where('type', $catalogue['formation']['type'])->get();
        $certificateType = Catalogue::where('type', $catalogue['certificate_type']['type'])->get();
        $compliance = Catalogue::where('type', $catalogue['compliance']['type'])->get();
        $control = Catalogue::where('type', $catalogue['control']['type'])->get();
        $courseType = Catalogue::where('type', $catalogue['course']['type'])->get();
        $frencuency = Catalogue::where('type', $catalogue['frecuency']['type'])->get();
        $modality = Catalogue::where('type', $catalogue['modality']['type'])->get();
        $meansVerification = Catalogue::where('type', $catalogue['means_verification']['type'])->get();
        $speciality = Catalogue::where('type', $catalogue['speciality_area']['type'])->get();
        $state = Catalogue::where('type', $catalogue['course_state']['type'])->get();

        return [
            'academic_period_id' => $this->faker->randomElement($academicPeriods),
            'entity_certification_id' => $this->faker->randomElement($entityCertification),
            'career_id' => $this->faker->randomElement($career[rand(0, sizeof($career) - 1)]),
            'category_id' => $this->faker->randomElement($category),
            'formation_type_id' => $this->faker->randomElement($formationType),
            'certified_type_id' => $this->faker->randomElement($certificateType),
            'compliance_indicators_id' => $this->faker->randomElement($compliance),
            'control_id' => $this->faker->randomElement($control),
            'course_type_id' => $this->faker->randomElement($courseType),
            'frecuency_id' => $this->faker->randomElement($frencuency),
            'modality_id' => $this->faker->randomElement($modality),
            'means_verification_id' => $this->faker->randomElement($meansVerification),
            'speciality_id' => $this->faker->randomElement($speciality),
            'responsible_id' => $this->faker->randomElement($responsible[rand(0, sizeof($responsible) - 1)]),
            'state_id' => $this->faker->randomElement($state),
            'abbreviation' => $this->faker->word(),
            'alignment' => $this->faker->words(3),
            'approved_at' => $this->faker->date('Y_m_d'),
            'bibliographies' => $this->faker->sentences(),
            'code' => $this->faker->numerify('COD-####'),
            'cost' => $this->faker->numberBetween(0, 100),
            'duration' => $this->faker->numberBetween(40, 200),
            'evaluation_mechanisms' => [
                'a' => [
                    'diagnostica' => $this->faker->words(2),
                    'formativa' => $this->faker->words(2)
                ],
                'b' => [
                    'diagnostica' => $this->faker->words(2),
                    'formativa' => $this->faker->words(2)
                ],
                'c' => [
                    'diagnostica' => $this->faker->words(2),
                    'formativa' => $this->faker->words(2)
                ]
            ],
            'expired_at' => $this->faker->date('Y_m_d'),
            'free' => $this->faker->randomElement(true, false),
            'name' => $this->faker->words(3),
            'needs' => $this->faker->words(6),
            'needed_at' => $this->faker->date('Y_m_d'),
            'record_number' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'learning_environments' => [
                'enviroments' => $this->faker->words(3)
            ],
            'local_proposal' => $this->faker->sentence(8),
            'objective' => $this->faker->sentence(10),
            'observation' => $this->faker->sentence(8),
            'practice_hours' => $this->faker->numberBetween(40, 200),
            'proposed_at' => $this->faker->date('Y_m_d'),
            'project' => $this->faker->sentence(8),
            'public' => $this->faker->randomElement(true, false),
            // 'required_installing_sources' => 'contenido',
            'setec_name' => $this->faker->words(3),
            'summary' => $this->faker->sentence(10),
            'target_groups' => [
                'target' => $this->faker->words(3)
            ],
            'teaching_strategies' => [
                'strategies' => $this->faker->words(3)
            ],
            'techniques_requisites' => [
                'requisites' => $this->faker->words(3)
            ],
            'theory_hours' => $this->faker->numberBetween(40, 200),
        ];
    }
}

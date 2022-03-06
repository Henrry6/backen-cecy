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
        $entityCertifications = Catalogue::where('type', $catalogue['entity_certification']['type'])->get();
        $careers = Career::get();
        $responsibles = Instructor::get();
        $categories = Catalogue::where('type', $catalogue['category']['type'])->get();
        $formationTypes = Catalogue::where('type', $catalogue['formation']['type'])->get();
        $certificateTypes = Catalogue::where('type', $catalogue['certificate_type']['type'])->get();
        $compliances = Catalogue::where('type', $catalogue['compliance']['type'])->get();
        $controls = Catalogue::where('type', $catalogue['control']['type'])->get();
        $courseTypes = Catalogue::where('type', $catalogue['course']['type'])->get();
        $frequencies = Catalogue::where('type', $catalogue['frequency']['type'])->get();
        $modalities = Catalogue::where('type', $catalogue['modality']['type'])->get();
        $meansVerifications = Catalogue::where('type', $catalogue['means_verification']['type'])->get();
        $specialities = Catalogue::where('type', $catalogue['speciality_area']['type'])->get();
        $states = Catalogue::where('code', $catalogue['course_state']['approved'])->first();

        return [
            'academic_period_id' => $this->faker->randomElement($academicPeriods),
            'entity_certification_id' => $this->faker->randomElement($entityCertifications),
            'career_id' => $this->faker->randomElement($careers),
            'category_id' => $this->faker->randomElement($categories),
            'formation_type_id' => $this->faker->randomElement($formationTypes),
            'certified_type_id' => $this->faker->randomElement($certificateTypes),
            'compliance_indicator_id' => $this->faker->randomElement($compliances),
            'control_id' => $this->faker->randomElement($controls),
            'course_type_id' => $this->faker->randomElement($courseTypes),
            'frequency_id' => $this->faker->randomElement($frequencies),
            'modality_id' => $this->faker->randomElement($modalities),
            'means_verification_id' => $this->faker->randomElement($meansVerifications),
            'speciality_id' => $this->faker->randomElement($specialities),
            'responsible_id' => $this->faker->randomElement($responsibles),
            'state_id' => $states,
            'abbreviation' => $this->faker->word(),
            'alignment' => $this->faker->word(),
            'approved_at' => $this->faker->date('Y_m_d'),
            'bibliographies' => $this->faker->sentences(),
            'code' => $this->faker->numerify('COD-####'),
            'cost' => $this->faker->numberBetween(0, 100),
            'duration' => $this->faker->numberBetween(40, 200),
            'evaluation_mechanisms' => [
                'diagnostic' => [[
                    'tecnique' => $this->faker->word(2),
                    'instrument' => $this->faker->word(2)
                ]],
                'formative' => [[
                    'technique' => $this->faker->word(2),
                    'instrument' => $this->faker->word(2)
                ]],
                'final' => [[
                    'tecnique' => $this->faker->word(2),
                    'instrument' => $this->faker->word(2)
                ]]
            ],
            'expired_at' => $this->faker->date('Y_m_d'),
            'free' => $this->faker->boolean(),
            'name' => $this->faker->word(),
            'needs' => $this->faker->words(6),
            'needed_at' => $this->faker->date('Y_m_d'),
            'record_number' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'learning_environments' => [[
                'installation' => $this->faker->word(),
                'theoreticalPhase' => $this->faker->randomElement([false, true]),
                'practicalPhase' => $this->faker->randomElement([false, true])
            ]],
            'local_proposal' => $this->faker->sentence(8),
            'objective' => $this->faker->sentence(10),
            'observations' => $this->faker->sentence(8),
            'practice_hours' => $this->faker->numberBetween(40, 200),
            'proposed_at' => $this->faker->date('Y_m_d'),
            'project' => $this->faker->sentence(8),
            'public' => $this->faker->boolean(),
            'setec_name' => $this->faker->word(),
            'summary' => $this->faker->sentence(),
            'target_groups' => $this->faker->words(3),
            'teaching_strategies' => $this->faker->sentences(),
            'techniques_requisites' => [
                'technical' => $this->faker->words(4),
                'general' => $this->faker->words(4),
            ],
            'theory_hours' => $this->faker->numberBetween(40, 200),
        ];
    }
}

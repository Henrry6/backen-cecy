<?php

namespace Database\Seeders\Develop\Cecy;

use Faker\Factory;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Course;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    public function run()
    {
        $this->createCoursesCatalogue();
        $this->createCourses();
    }

    public function createCoursesCatalogue()
    {
        $catalogue = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory(42)->sequence(
            [
                'code' => $catalogue['academic_period']['first'],
                'name' => 'PRIMERO',
                'type' => $catalogue['academic_period']['type'],
                'description' => 'Primer semestre'
            ],
            [
                'code' => $catalogue['academic_period']['second'],
                'name' => 'SEGUNDO',
                'type' => $catalogue['academic_period']['type'],
                'description' => 'Segundo semestre'
            ],
            [
                'code' => $catalogue['academic_period']['third'],
                'name' => 'TERCERO',
                'type' => $catalogue['academic_period']['type'],
                'description' => 'Terccer semestre'
            ],
            [
                'code' => $catalogue['academic_period']['fourth'],
                'name' => 'CUARTO',
                'type' => $catalogue['academic_period']['type'],
                'description' => 'Cuarto semestre'
            ],
            [
                'code' => $catalogue['academic_period']['fifth'],
                'name' => 'QUINTO',
                'type' => $catalogue['academic_period']['type'],
                'description' => 'Quinto semestre'
            ],
            [
                'code' => $catalogue['academic_period']['sixth'],
                'name' => 'SEXTO',
                'type' => $catalogue['academic_period']['type'],
                'description' => 'Sexto semestre'
            ],
            [
                'code' => $catalogue['academic_period']['seventh'],
                'name' => 'SEPTIMO',
                'type' => $catalogue['academic_period']['type'],
                'description' => 'Septimo semestre'
            ],
            [
                'code' => $catalogue['area']['a'],
                'name' => 'ADMINISTRACI??N Y LEGISLACI??N',
                'type' => $catalogue['area']['type'],
                'description' => null
            ],
            [
                'code' => $catalogue['area']['b'],
                'name' => 'AGRONOM??A',
                'type' => $catalogue['area']['type'],
                'description' => null
            ],
            [
                'code' => $catalogue['entity_certification']['senecyt'],
                'name' => 'Senecyt',
                'type' => $catalogue['entity_certification']['type'],
                'description' => 'Cuando la instituci??n que lo avala es la Senecyt'
            ],
            [
                'code' => $catalogue['entity_certification']['setec'],
                'name' => 'Setec',
                'type' => $catalogue['entity_certification']['type'],
                'description' => 'Cuando la instituci??n que lo avala es la Setec'
            ],
            [
                'code' => $catalogue['entity_certification']['cecy'],
                'name' => 'Cecy',
                'type' => $catalogue['entity_certification']['type'],
                'description' => 'Cuando la instituci??n que lo avala es la Cecy'
            ],
            [
                'code' => $catalogue['category']['technical'],
                'name' => 'T??cnico',
                'type' => $catalogue['category']['type'],
                'description' => 'Cuando el curso es t??cnico'
            ],
            [
                'code' => $catalogue['category']['administrative'],
                'name' => 'Administrativo',
                'type' => $catalogue['category']['type'],
                'description' => 'Cuando el curso es administrativo'
            ],
            [
                'code' => $catalogue['category']['english'],
                'name' => 'Ingl??s',
                'type' => $catalogue['category']['type'],
                'description' => 'Cuando el curso es de Ingles'
            ],
            [
                'code' => $catalogue['category']['teaching_course'],
                'name' => 'Docencia',
                'type' => $catalogue['category']['type'],
                'description' => 'Cuando el curso es de docencia'
            ],
            [
                'code' => $catalogue['category']['patern_tailoring'],
                'name' => 'Patronaje y confecci??n',
                'type' => $catalogue['category']['type'],
                'description' => 'Cuando el curso es de patronaje y confecci??n'
            ],
            [
                'code' => $catalogue['category']['pedagogical'],
                'name' => 'Pedag??gico',
                'type' => $catalogue['category']['type'],
                'description' => 'Cuando el curso es de pedagog??a'
            ],
            [
                'code' => $catalogue['formation']['course'],
                'name' => 'Curso',
                'type' => $catalogue['formation']['type'],
                'description' => 'Cuando el curso es de tipo capacitaci??n'
            ],
            [
                'code' => $catalogue['formation']['workshop'],
                'name' => 'Taller',
                'type' => $catalogue['formation']['type'],
                'description' => 'Cuando el curso es de tipo taller'
            ],
            [
                'code' => $catalogue['formation']['webinar'],
                'name' => 'Webinar',
                'type' => $catalogue['formation']['type'],
                'description' => 'Cuando el curso es de tipo Webinar'
            ],
            [
                'code' => $catalogue['certificate']['assistance'],
                'name' => 'Asistencia',
                'type' => $catalogue['certificate']['type'],
                'description' => 'Cuando se obtiene un certificado por asistencia'
            ],
            [
                'code' => $catalogue['certificate']['approval'],
                'name' => 'Aprobaci??n',
                'type' => $catalogue['certificate']['type'],
                'description' => 'Cuando se obtiene un certificado por aprobaci??n'
            ],
            [
                'code' => $catalogue['course']['technical'],
                'name' => 'T??cnico',
                'type' => $catalogue['course']['type'],
                'description' => 'Cuando el curso es de tipo T??cnico'
            ],
            [
                'code' => $catalogue['course']['administrative'],
                'name' => 'Administrativo',
                'type' => $catalogue['course']['type'],
                'description' => 'Cuando el curso es de tipo administrativo'
            ],
            [
                'code' => $catalogue['modality']['presencial'],
                'name' => 'Presencial',
                'type' => $catalogue['modality']['type'],
                'description' => 'Cuando el curso se dicta de manera presencial'
            ],
            [
                'code' => $catalogue['modality']['virtual'],
                'name' => 'Virtual',
                'type' => $catalogue['modality']['type'],
                'description' => 'Cuando el curso se dicta de manera virtual'
            ],
            [
                'code' => $catalogue['participant']['teacher'],
                'name' => 'Docente',
                'type' => $catalogue['participant']['type'],
                'description' => 'Cuando el curso esta dedicado docentes'
            ],
            [
                'code' => $catalogue['participant']['public_company'],
                'name' => 'Empresa p??blica',
                'type' => $catalogue['participant']['type'],
                'description' => 'Cuando el curso esta dedicado para participantes de una empresa p??blica'
            ],
            [
                'code' => $catalogue['participant']['private_company'],
                'name' => 'Empresa privada',
                'type' => $catalogue['participant']['type'],
                'description' => 'Cuando el curso esta dedicado para participantes de una empresa privada'
            ],
            [
                'code' => $catalogue['participant']['training_company'],
                'name' => 'Empresa formadora',
                'type' => $catalogue['participant']['type'],
                'description' => 'Cuando un participante del curso es parte de una empresa formadora'
            ],
            [
                'code' => $catalogue['participant']['external_student'],
                'name' => 'Estudiante externo',
                'type' => $catalogue['participant']['type'],
                'description' => 'Cuando el curso esta dedicado para estudiantes externos'
            ],
            [
                'code' => $catalogue['participant']['internal_student'],
                'name' => 'Estudiante interno',
                'type' => $catalogue['participant']['type'],
                'description' => 'Cuando el curso esta dedicado para estudiantes internos'
            ],
            [
                'code' => $catalogue['participant']['senecyt_staff'],
                'name' => 'Senecyt',
                'type' => $catalogue['participant']['type'],
                'description' => 'Cuando el curso esta dedicado para personal del senecyt'
            ],
            [
                'code' => $catalogue['participant']['gad'],
                'name' => 'GAD',
                'type' => $catalogue['participant']['type'],
                'description' => 'Cuando el curso esta dedicado para personal del GAD'
            ],
            [
                'code' => $catalogue['course_state']['defeated'],
                'name' => 'Vencido',
                'type' => $catalogue['course_state']['type'],
                'description' => 'Cuando el estado del curso es vencido'
            ],
            [
                'code' => $catalogue['course_state']['to_be_approved'],
                'name' => 'Por aprobar',
                'type' => $catalogue['course_state']['type'],
                'description' => 'Cuando el estado del curso es por aprobar'
            ],
            [
                'code' => $catalogue['course_state']['approved'],
                'name' => 'Aprobado',
                'type' => $catalogue['course_state']['type'],
                'description' => 'Cuando el estado del curso es aprobado'
            ],
            [
                'code' => $catalogue['course_state']['not_approved'],
                'name' => 'No aprobado',
                'type' => $catalogue['course_state']['type'],
                'description' => 'Cuando el estado del curso es no parobado'
            ],
            [
                'code' => $catalogue['target_groups']['children'],
                'name' => 'Ni??os',
                'type' => $catalogue['target_groups']['type'],
                'description' => 'Grupo al que va dirigido'
            ],
            [
                'code' => $catalogue['target_groups']['young'],
                'name' => 'Adolescente',
                'type' => $catalogue['target_groups']['type'],
                'description' => 'Grupo al que va dirigido'
            ],
            [
                'code' => $catalogue['target_groups']['adult'],
                'name' => 'Adultos',
                'type' => $catalogue['target_groups']['type'],
                'description' => 'Grupo al que va dirigido'
            ],
            
        )->create();

        $faker = Factory::create();

        $area_type = Catalogue::Where('type', 'AREA')->get();
        Catalogue::factory(4)->sequence(
            [
                'code' => $catalogue['speciality_area']['a.1'],  
                'name' => 'Administraci??n General (P??blica, Empresas, Microempresas, Cooperativas, Aduanera, Agr??cola, Agropecuaria, Agroindustrial, Bancaria, Financiera, Forestal, Hospitalaria, Hotelera, Inmobiliaria, Pesquera, Minera, Etc.)',
                'type' => $catalogue['speciality_area']['type'],
                'parent_id' => $faker->randomElement($area_type)
            ],
            [
                'code' => $catalogue['speciality_area']['a.2'],  
                'name' => 'Gesti??n del Talento Humano (Manejo de Personal, Desempe??o, Motivaci??n, Liderazgo, Coaching, Trabajo en Equipo, Selecci??n por Competencias, Plan Interno de Carrera, Comunicaci??n Organizacional, Profesiogramas)',
                'type' => $catalogue['speciality_area']['type'],
                'parent_id' => $faker->randomElement($area_type)
            ],
            [
                'code' => $catalogue['speciality_area']['b.1'],  
                'name' => 'Administraci??n de Costos',
                'type' => $catalogue['speciality_area']['type'],
                'parent_id' => $faker->randomElement($area_type)
            ],
            [
                'code' => $catalogue['speciality_area']['b.2'],  
                'name' => 'Administraci??n Contable',
                'type' => $catalogue['speciality_area']['type'],
                'parent_id' => $faker->randomElement($area_type)
            ]
        )->create();
    }

    public function createCourses()
    {
        Course::factory(30)->create();
    }
}

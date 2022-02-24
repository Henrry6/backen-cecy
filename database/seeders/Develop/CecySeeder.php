<?php

namespace Database\Seeders\Develop;

use App\Models\Cecy\Planification;
use Database\Seeders\Develop\Cecy\AdditionalInformationsSeeder;
use Database\Seeders\Develop\Cecy\AttendancesSeeder;
use Database\Seeders\Develop\Cecy\AuthoritiesSeeder;
use Database\Seeders\Develop\Cecy\AuthorizedInstructorsSeeder;
use Database\Seeders\Develop\Cecy\CecyCatalogueSeeder;
use Database\Seeders\Develop\Cecy\CertificatesSeeder;
use Database\Seeders\Develop\Cecy\ClassroomsSeeder;
use Database\Seeders\Develop\Cecy\CoursesSeeder;
use Database\Seeders\Develop\Cecy\DetailAttendancesSeeder;
use Database\Seeders\Develop\Cecy\DetailPlanificationsInstructorSeeder;
use Database\Seeders\Develop\Cecy\DetailPlanificationsSeeder;
use Database\Seeders\Develop\Cecy\DetailSchoolPeriodsSeeder;
use Database\Seeders\Develop\Cecy\InstitutionsSeeder;
use Database\Seeders\Develop\Cecy\InstructorsSeeder;
use Database\Seeders\Develop\Cecy\NotificationsSeeder;
use Database\Seeders\Develop\Cecy\ParticipantCourseSeeder;
use Database\Seeders\Develop\Cecy\ParticipantsSeeder;
use Database\Seeders\Develop\Cecy\PhotographicRecordsSeeder;
use Database\Seeders\Develop\Cecy\PlanificationsSeeder;
use Database\Seeders\Develop\Cecy\PrerequisitesSeeder;
use Database\Seeders\Develop\Cecy\ProfileInstructorCoursesSeeder;
use Database\Seeders\Develop\Cecy\RegistrationRequerimentsSeeder;
use Database\Seeders\Develop\Cecy\RegistrationsSeeder;
use Database\Seeders\Develop\Cecy\RequirementsSeeder;
use Database\Seeders\Develop\Cecy\SchoolPeriodsSeeder;
use Database\Seeders\Develop\Cecy\TopicsSeeder;
use Illuminate\Database\Seeder;


class CecySeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ClassroomsSeeder::class,
            InstructorsSeeder::class,
            CoursesSeeder::class,
            InstitutionsSeeder::class,
            RequirementsSeeder::class,
            SchoolPeriodsSeeder::class,
            AuthoritiesSeeder::class,
            DetailSchoolPeriodsSeeder::class,
            ParticipantsSeeder::class,
            PlanificationsSeeder::class,
            DetailPlanificationsSeeder::class,
            RegistrationsSeeder::class,
            AdditionalInformationsSeeder::class,
            RegistrationRequerimentsSeeder::class,
            PrerequisitesSeeder::class,
            ProfileInstructorCoursesSeeder::class,
            TopicsSeeder::class,
            AttendancesSeeder::class,
            ParticipantCourseSeeder::class,
            DetailAttendancesSeeder::class,
            DetailPlanificationsInstructorSeeder::class,
            // AuthorizedInstructorsSeeder::class,
            //CertificatesSeeder::class,
            //NotificationsSeeder::class,
            PhotographicRecordsSeeder::class,
        ]);
    }
}

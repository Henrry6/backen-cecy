<?php

namespace App\Imports;

use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Registration;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegistrationImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
   /**
    * @param array $row
    * @return \Illuminate\Database\Eloquent\Model|null

*/
    private $participants;
    private $detailPlanifications;

    public function __construct()
    {
        $this->participants = Participant::pluck('id');
        $this->detailPlanifications = DetailPlanification::pluck('id');
    }
public function model(array $row)
{
    return new Registration([
        'participant_id' => $this->participants[$row['participants']],
        'detail_planification_id' => $this->detailPlanifications[$row['detailPlanifications']],
        'grade1' => $row['primer_parcial'],
        'grade2' => $row['segundo_parcial'],
        'final_grade' => $row['nota_final'],
    ]);
}

    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}

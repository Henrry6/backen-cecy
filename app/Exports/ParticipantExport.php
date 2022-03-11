<?php

namespace App\Exports;

use App\Models\Cecy\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;

class ParticipantExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Participant::all();
    }
}

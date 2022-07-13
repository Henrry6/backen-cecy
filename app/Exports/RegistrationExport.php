<?php

namespace App\Exports;

use App\Models\Cecy\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;

class RegistrationExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Registration::with('participant')->get();
    }
}

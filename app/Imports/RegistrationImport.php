<?php

namespace App\Imports;

use App\Models\Cecy\Registration;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RegistrationImport implements ToCollection, WithHeadingRow, WithValidation
{
   /**
    * @param array $row
    * @return \Illuminate\Database\Eloquent\Model|null

*/
    public function __construct()
    {
    }
public function collection(Collection $rows)
{
    foreach ($rows as $row){
        $registration = Registration::find($row['id']);
        $registration->grade1 = $row['primer_parcial'];
        $registration->grade2 = $row['segundo_parcial'];
        $registration->final_grade = ($row['primer_parcial'] + $row['segundo_parcial'])/2;
        $registration->save();
    }
}
    public function rules(): array
    {
        return [
            'primer_parcial' =>[
                'numeric',
                'required',
                'min:0',
                'max:100'

            ] ,
            'segundo_parcial' =>[
                'numeric',
                'required',
                'min:0',
                'max:100'
            ] ,
        ];
    }

}

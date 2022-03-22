<?php

namespace App\Imports;

use App\Models\Cecy\Certificate;
use Maatwebsite\Excel\Concerns\ToModel;

class CertificatesImport implements ToModel
{
   /** 
    * @param array $row
    * @return \Illuminate\Database\Eloquent\Model|null

*/

public function model(array $row)
{   
    return new Certificate([
        'certificateable_type' => 'prueba',
        'certificateable_id' => 0,
        'state_id' => 20,
        'code' => $row['4'],
        'issued_at' => '10-3-2022',
    ]);
}




}

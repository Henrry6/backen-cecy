<?php

namespace App\Exports;


use App\Http\Resources\V1\Cecy\Registrations\RegistrationCollection;
use App\Models\Cecy\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;



class RegistrationExport implements FromCollection, WithMapping,WithHeadings
{
    private $detailPlanification;

    public function __construct($detailPlanification)
    {
        $this->detailPlanification = $detailPlanification;
    }

    public function collection()
    {
        return new RegistrationCollection(
            Registration::where('detail_planification_id','=', $this->detailPlanification)
            ->get()
        );
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->participant ? $row->participant->user->username: '',
            $row->participant ? $row->participant->user->name: '',
            $row->participant ? $row->participant->user->lastname: '',
            $row->participant ? $row->participant->user->email: '',
            $row->participant ? $row->participant->user->phone: '',
            $row->grade1,
            $row->grade2,
            $row->final_grade,

        ];
    }

    public function headings(): array
    {
        $headers = [
            'Id',
            'Cedula',
            'Nombre',
            'Apellido',
            'Correo',
            'Telefono',
            'Primer Parcial',
            'Segundo Parcial',
            'Nota Final',
        ];

        return $headers;
    }
}

<?php

namespace App\Exports;

use App\Models\Worklog;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorklogsExport implements FromCollection,WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Worklog::with(['project', 'user'])->get();
        
    }
    public function headings(): array
    {
        return ['Project','User', 'Date', 'Description'];
    }

    public function map($worklog): array
    {
        return [
            $worklog->project ? $worklog->project->name : 'N/A',
            $worklog->user ? $worklog->user->name : 'N/A',
            $worklog->date,
            $worklog->description,
        ];
    }
     public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], 
        ];
    }
}

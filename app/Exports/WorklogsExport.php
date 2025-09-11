<?php

namespace App\Exports;

use App\Models\Worklog;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class WorklogsExport implements FromCollection,WithHeadings, WithMapping
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
        return ['Title', 'Project', 'User', 'Date'];
    }

    public function map($worklog): array
    {
        return [
            $worklog->title,
            $worklog->project ? $worklog->project->name : 'N/A',
            $worklog->user ? $worklog->user->name : 'N/A',
            $worklog->date,
        ];
    }
}

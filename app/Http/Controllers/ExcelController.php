<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\WorklogsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function exportExcel()
{
    return Excel::download(new WorklogsExport, 'worklogs.xlsx');
}
}

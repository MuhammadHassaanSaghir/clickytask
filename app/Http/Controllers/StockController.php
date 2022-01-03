<?php

namespace App\Http\Controllers;

use App\Exports\StockExport;
use App\Imports\StockImport;
use Illuminate\Http\Request;
use Excel;

class StockController extends Controller
{
    public function importCsv(Request $request)
    {
        Excel::import(new StockImport, $request->csv_file);
        return redirect('home')->with('success', 'File Import Successfully');
    }

    public function exportExcel()
    {
        return Excel::download(new StockExport, 'Sample2.xlsx');
    }
}

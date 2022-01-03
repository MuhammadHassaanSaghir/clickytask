<?php

namespace App\Http\Controllers;

use App\Exports\StockExport;
use App\Imports\StockImport;
use App\Jobs\StockCsvProcess;
use App\Models\Stock;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Bus;

class StockController extends Controller
{

    public function importCsv(Request $request)
    {
        if ($request->has('csv_file')) {
            // $csv    = file($request->csv_file);
            // $chunks = array_chunk($csv, 2);
            // $header = [];
            // $batch  = Bus::batch([])->dispatch();

            // foreach ($chunks as $key => $chunk) {
            //     $data = array_map('str_getcsv', $chunk);
            //     if ($key == 0) {
            //         $header = $data[0];
            //         unset($data[0]);
            //     }
            //     $batch->add(new StockCsvProcess($data, $header));
            // }
            // return $batch;
            Excel::import(new StockImport, $request->csv_file);
            return redirect('home')->with('success', 'File Import Successfully');
        } else {
            return redirect('home')->with('success', 'Please Upload File');
        }
    }

    public function exportExcel()
    {
        return Excel::download(new StockExport, 'Sample2.xlsx');
    }
}

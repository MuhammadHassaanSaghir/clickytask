<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\withHeadings;

class StockExport implements FromCollection, withHeadings
{
    public function headings(): array
    {
        return [
            'sku',
            'stock_id'
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Stock::all();
        return collect(Stock::getStock());
    }
}

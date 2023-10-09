<?php

namespace App\Exports;

use App\Models\PurchaseOrderLine;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PurchaseOrderLine::all();
    }
}

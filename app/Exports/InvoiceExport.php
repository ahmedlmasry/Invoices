<?php

namespace App\Exports;

use App\Models\Invoice;


class InvoiceExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Invoice::all();

    }
}

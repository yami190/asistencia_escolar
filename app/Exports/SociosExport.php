<?php

namespace App\Exports;

use App\Mov_temp;
use Maatwebsite\Excel\Concerns\FromCollection;

class SociosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Mov_temp::all();
    }
}

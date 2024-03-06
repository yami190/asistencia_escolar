<?php

namespace App\Imports;

use App\Mov_temp;
use Maatwebsite\Excel\Concerns\ToModel;

class SocioMov implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Mov_temp([
            'cedula' => $row[0],  
            'apor_ahorro' => $row[1], 
            'apor_presta' => $row[2], 
            'seguro' => $row[3],  
            'mes'=> $row[4], 
            'ano' => $row[5], 
            'condicion' => $row[6]
        ]);
    }
}

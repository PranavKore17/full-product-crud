<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToModel,WithStartRow
{
    /**
    * @param Collection $collection
    */

    public function startRow(): int
    {
        return 3;
    }

    public function model(array $row)
    {
        return new Product([
        //    'id'=>$row[0],
           'name'=>$row[0],
           'description'=>$row[1],
           'from_date'=>$row[2],
           'to_date'=>$row[3],
        //    'multi'=>$row[5],
        //    'image'=>$row[6],
        //    'created_at'=>$row[7],
        //    'updated_at'=>$row[8],

        ]);
    }
}

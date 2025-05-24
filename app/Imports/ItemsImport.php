<?php

namespace App\Imports;

use App\Models\items;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class ItemsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $items = Items::where('product_name', $row['product_name'])->first();

        if($items){
            $items->update([
                'product_name'  => $row['product_name'],
                'barcode'  => $row['barcode'],
                'hsn_code'  => $row['hsn_code'],
                'price_per_unit'  => $row['price_per_unit'],
                'selling_price_per_unit'  => $row['selling_price_per_unit'],
                'unit_id' => $row['unit_id'],
                'tax_type_id'    => $row['tax_type_id'],
                'tax_percentage'    => $row['tax_percentage'],
                'description'    => $row['description'],
            ]);
        }else{
            return new items([
                'product_name'  => $row['product_name'],
                'barcode'  => $row['barcode'],
                'hsn_code'  => $row['hsn_code'],
                'price_per_unit'  => $row['price_per_unit'],
                'selling_price_per_unit'  => $row['selling_price_per_unit'],
                'unit_id' => $row['unit_id'],
                'tax_type_id'    => $row['tax_type_id'],
                'tax_percentage'    => $row['tax_percentage'],
                'description'    => $row['description'],
            ]);

        }
        
    }
}

<?php

namespace App\Imports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class CustomersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $customer = Customers::where('email', $row['email'])->first();

        if($customer){
            $customer->update([
                'customer_name'  => $row['customer_name'],
                'address' => $row['address'],
                'contact_number'    => $row['contact_number'],
                'email'    => $row['email'],
                'is_gst'    => $row['is_gst'],
                'gst_number'    => $row['gst_number'],
                'description'    => $row['description'],
            ]);
        }else{
            return new Customers([
                'customer_name'  => $row['customer_name'],
                'address' => $row['address'],
                'contact_number'    => $row['contact_number'],
                'email'    => $row['email'],
                'is_gst'    => $row['is_gst'],
                'gst_number'    => $row['gst_number'],
                'description'    => $row['description'],
            ]);

        }
    }
}

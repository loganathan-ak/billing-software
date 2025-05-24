<?php

namespace App\Imports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VendorsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
    
        $vendor = Vendor::where('phone', $row['phone'])->first();
    
        if ($vendor) {
            // Update existing vendor
            $vendor->update([
                'vendor_name'    => $row['vendor_name'],
                'contact_person' => $row['contact_person'],
                'address'        => $row['address'],
                'phone'          => $row['phone'],
                'is_gst'         => $row['is_gst'],
                'gst_number'     => $row['gst_number'],
                'description'    => $row['description'],
            ]);
        } else {
            // Create new vendor
            return new Vendor([
                'vendor_name'    => $row['vendor_name'],
                'contact_person' => $row['contact_person'],
                'address'        => $row['address'],
                'phone'          => $row['phone'],
                'is_gst'         => $row['is_gst'],
                'gst_number'     => $row['gst_number'],
                'description'    => $row['description'],
            ]);
        }
    }
    
    
}

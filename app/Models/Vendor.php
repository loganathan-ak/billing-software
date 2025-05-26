<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vendor extends Model
{
    protected $fillable = [
        'vendor_name',
        'contact_person',
        'address',
        'phone',
        'is_gst',
        'gst_number',
        'description',
    ];
    
}

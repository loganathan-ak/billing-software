<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable = [
        'customer_name',
        'address',
        'contact_number',
        'email',
        'is_gst',
        'gst_number',
        'description',
    ];

    // In Customers.php model
public function chits()
{
    return $this->hasMany(Chits::class, 'customer_id');
}

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    protected $fillable = [
        'invoice_date',
        'invoice_number',
        'vendor_id',
        'payment_status',
        'paid_amount',
        'balance',
        'item_details',
        'description',
        'subtotal',
        'total_tax',
        'grand_total',
    ];
    
    
    
}

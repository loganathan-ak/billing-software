<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinesstoBusiness extends Model
{
    protected $table = 'businessto_businesses';

    protected $fillable = [
        'invoice_date',
        'invoice_number',
        'customer_id',
        'payment_status',
        'payment_method',
        'paid_amount',
        'balance',
        'item_details',
        'description',
        'subtotal',
        'total_tax',
        'grand_total',
        'discount_percent',
        'discount_amount',
        'created_by',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoices extends Model
{
    protected $fillable = [
        'invoice_date',
        'invoice_number',
        'customer_id',
        'customer_name',
        'customer_phone',
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

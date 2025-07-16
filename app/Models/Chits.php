<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chits extends Model
{
    protected $fillable = [
      'chit_number',
      'customer_id',
      'chit_type',
      'start_date',
      'monthly_amount',
      'total_months',
      'description',
      'payment_date',
      'amount_paid',
      'month_number',
      'discount_percent',
      'due_status', 
      'chit_status',
      'wallet_balance', 
      'totally_paid_amount',
  ];

}

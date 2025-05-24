<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $fillable = [
        'expense_name',
        'expense_type',
        'amount',
        'beneficiary_name',
        'description',
    ];
    
}

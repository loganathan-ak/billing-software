<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = [
        'barcode',
        'product_name',    // Item name
        'hsn_code',
        'price_per_unit',
        'selling_price_per_unit',
        'unit_id',         // Unit (Piece, Dozen, etc.)
        'tax_type_id',     // Tax type (GST, IGST, Exempt)
        'tax_percentage',  // Tax percentage (e.g., 5.00)
        'description',     // Description of the item
        'current_stock',
    ];
}

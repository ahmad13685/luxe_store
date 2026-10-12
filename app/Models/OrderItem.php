<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A single product line inside an order (product + quantity + price).
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_name',
        'product_image',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    /**
     * The order this line item belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

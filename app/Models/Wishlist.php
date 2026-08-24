<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',      // ← YEH ADD KAREIN
        'product_name',
        'product_image',
        'price',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

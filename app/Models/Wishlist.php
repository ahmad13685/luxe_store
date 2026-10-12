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

    /**
     * product_image on this table is a raw copy of whatever was in
     * Product::image at the time the item was wishlisted (seed "pic/...",
     * a new "uploads/products/..." upload, or a legacy "products/..." path).
     * Route it through the same resolver everything else uses instead of
     * assuming it's always a seed image.
     */
    public function getImageUrlAttribute(): string
    {
        return \App\Support\ProductImageResolver::url($this->product_image);
    }
}

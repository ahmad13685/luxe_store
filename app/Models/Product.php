<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'category',
        'category_id',
        'product_code',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order');
    }

public function category(): BelongsTo

{

return $this->belongsTo(Category::class);

}

    protected static function booted(): void
    {
        static::saving(function (self $product) {
            // Keep the legacy `category` string column in sync automatically,
            // so any existing storefront code reading $product->category as
            // plain text keeps working with zero changes.
            if ($product->category_id) {
                $product->category = Category::find($product->category_id)?->name;
            }

            if (empty($product->product_code) && $product->category_id) {
                $category = Category::find($product->category_id);
                $count = static::where('category_id', $product->category_id)->count();
                $product->product_code = $category->code . str_pad($count + 1, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return asset('pic/p1.webp');
        }

        return asset($this->image);
    }
}

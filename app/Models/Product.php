<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
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
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getCategoryNameAttribute(): string
    {
        return $this->category?->name ?? 'General';
    }
    public function getImageUrlAttribute(): string
    {
        return \App\Support\ProductImageResolver::url($this->image);
    }
    protected static function booted(): void
    {
        static::saving(function (self $product) {
            if (blank($product->slug) && filled($product->name)) {
                $base = Str::slug($product->name);
                $slug = $base ?: 'product';
                $suffix = 2;

                while (static::where('slug', $slug)->whereKeyNot($product->getKey())->exists()) {
                    $slug = $base . '-' . $suffix++;
                }

                $product->slug = $slug;
            }

            if (empty($product->product_code) && $product->category_id) {
                $category = Category::find($product->category_id);

                if ($category) {
                    $count = static::where('category_id', $product->category_id)
                        ->where('id', '!=', $product->getKey())
                        ->count();

                    $product->product_code = $category->code . str_pad($count + 1, 5, '0', STR_PAD_LEFT);
                }
            }
        });
    }
}

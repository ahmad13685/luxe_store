<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $category): void {
            if (filled($category->code)) {
                return;
            }

            $lastCode = static::query()
                ->whereNotNull('code')
                ->orderByDesc('code')
                ->value('code');

            $next = $lastCode ? ((int) $lastCode) + 1 : 1;

            if ($next > 99) {
                throw new \RuntimeException('Maximum of 99 categories has been reached.');
            }

            $category->code = str_pad((string) $next, 2, '0', STR_PAD_LEFT);
        });
    }
}

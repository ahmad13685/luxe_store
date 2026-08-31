<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnReplacement extends Model
{
    use HasFactory;

    protected $table = 'returns_replacements';

    protected $fillable = ['order_item_id', 'type', 'reason', 'status'];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}

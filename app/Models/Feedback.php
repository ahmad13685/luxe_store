<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * Eloquent's default table-name guesser treats "feedback" as an
     * uncountable noun (Str::plural('Feedback') === 'feedback'), but the
     * migration created the table as `feedbacks`. Without this, every
     * query on this model — including the entire Filament Feedback admin
     * section — fails with "Table 'feedbacks'/'feedback' doesn't exist".
     */
    protected $table = 'feedbacks';

    protected $fillable = ['customer_id', 'order_id', 'rating', 'comments'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

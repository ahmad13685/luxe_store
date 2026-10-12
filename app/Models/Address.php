<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A shipping or billing address that belongs to one customer.
 */
class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'type',
        'full_name',
        'phone',
        'address_line',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * The customer this address belongs to.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Small helper to print the address as one readable line,
     * used on the Order Details page.
     */
    public function formatted(): string
    {
        return "{$this->address_line}, {$this->city}, {$this->state} {$this->postal_code}, {$this->country}";
    }
}

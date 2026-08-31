<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
    'customer_id',
    'order_number',
    'status',
    'payment_method',
    'payment_status',
    'card_last4',
    'cheque_number',
    'subtotal',
    'shipping_fee',
    'total_amount',
    'shipping_address',      // ← YEH LINE ADD KAREIN
    'shipping_address_id',
    'billing_address_id',
    'dispatched_by',
    'dispatched_at',
    'delivered_at',
];

    // ---------------------------------------------------------------
    // STATUS CONSTANTS
    // Using constants (instead of typing the string everywhere) means
    // if we ever need to rename a status we only change it in one place.
    // ---------------------------------------------------------------
    const STATUS_PENDING           = 'Pending';
    const STATUS_PAYMENT_VERIFIED  = 'Payment Verified';
    const STATUS_PROCESSING        = 'Processing';
    const STATUS_PACKED            = 'Packed';
    const STATUS_DISPATCHED        = 'Dispatched';
    const STATUS_OUT_FOR_DELIVERY  = 'Out For Delivery';
    const STATUS_DELIVERED         = 'Delivered';

    /**
     * The full tracking timeline, in order. Used on the Order Tracking
     * page to work out which steps are already complete.
     */
    public static function statusSteps(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_PAYMENT_VERIFIED,
            self::STATUS_PROCESSING,
            self::STATUS_PACKED,
            self::STATUS_DISPATCHED,
            self::STATUS_OUT_FOR_DELIVERY,
            self::STATUS_DELIVERED,
        ];
    }

    /**
     * Bootstrap function - runs automatically whenever a new Order
     * is being created, so every order gets a unique 16-digit
     * order_number without the controller having to think about it.
     */
    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateUniqueOrderNumber();
            }
        });
    }

    /**
     * Keeps generating a random 16-digit number until it finds one
     * that isn't already used by another order.
     */
    public static function generateUniqueOrderNumber(): string
    {
        do {
            // str_pad makes sure we always get exactly 16 digits,
            // even if random_int happens to start with zeros.
            $number = '';
            for ($i = 0; $i < 16; $i++) {
                $number .= random_int(0, 9);
            }
        } while (self::where('order_number', $number)->exists());

        return $number;
    }

    /**
     * Bootstrap badge color to use for each status, kept here so
     * every Blade view (dashboard, orders table, tracking page)
     * shows the exact same color for the exact same status.
     */
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING          => 'status-badge status-pending',
            self::STATUS_PAYMENT_VERIFIED => 'status-badge status-info',
            self::STATUS_PROCESSING       => 'status-badge status-info',
            self::STATUS_PACKED           => 'status-badge status-info',
            self::STATUS_DISPATCHED       => 'status-badge status-progress',
            self::STATUS_OUT_FOR_DELIVERY => 'status-badge status-progress',
            self::STATUS_DELIVERED        => 'status-badge status-success',
            default                       => 'status-badge status-pending',
        };
    }

    /**
     * The customer who placed this order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The products inside this order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * The address this order ships to.
     */
    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    /**
     * The address on the invoice/billing.
     */
    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    /**
     * The admin/employee who dispatched this order.
     */
    public function dispatcher()
    {
        return $this->belongsTo(User::class, 'dispatched_by');
    }

    /**
     * Business rule: block dispatch until payment has cleared
     * (Cash on Delivery orders skip this check).
     */
    public function canBeDispatched(): bool
    {
        return $this->payment_method === 'Cash on Delivery'
            || $this->payment_status === 'cleared';
    }

    /**
     * Business rule: customer can only cancel before it's packed.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_PAYMENT_VERIFIED,
            self::STATUS_PROCESSING,
        ]);
    }

}

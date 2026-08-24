<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A registered shopper who can log in to the Customer Dashboard.
 * Authentication for this model is handled with plain sessions
 * (see EnsureCustomerIsLoggedIn middleware) - no Laravel auth guard.
 */
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'profile_photo',
    ];

    // Never accidentally show the password when the model is
    // converted to an array or JSON.
    protected $hidden = [
        'password',
    ];

    /**
     * All the addresses this customer has saved.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * All the orders this customer has placed.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * All the products this customer has added to their wishlist.
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Returns the uploaded profile photo URL, or null if the
     * customer hasn't uploaded one yet (views fall back to showing
     * their initials instead, so no placeholder image file is needed).
     */
    public function photoUrl(): ?string
    {
        return $this->profile_photo
            ? asset('pic/customers/' . $this->profile_photo)
            : null;
    }

    /**
     * First letter of the customer's name, used for the little
     * circle avatar when no profile photo has been uploaded.
     */
    public function initials(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }
}

<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Gives every seeded customer one default shipping address.
     */
    public function run(): void
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            Address::create([
                'customer_id'  => $customer->id,
                'type'         => 'shipping',
                'full_name'    => $customer->name,
                'phone'        => $customer->phone,
                'address_line' => '221B Baker Street',
                'city'         => 'Karachi',
                'state'        => 'Sindh',
                'postal_code'  => '75500',
                'country'      => 'Pakistan',
                'is_default'   => true,
            ]);
        }
    }
}

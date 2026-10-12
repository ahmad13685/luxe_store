<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Creates a couple of test accounts so the dashboard can be
     * logged into and tested right after seeding.
     *
     * Login with:
     *   email:    john@example.com
     *   password: password
     */
    public function run(): void
    {
        Customer::create([
            'name'     => 'John Carter',
            'email'    => 'john@example.com',
            'phone'    => '+92 300 1234567',
            'password' => Hash::make('password'),
        ]);

        Customer::create([
            'name'     => 'Sarah Malik',
            'email'    => 'sarah@example.com',
            'phone'    => '+92 301 7654321',
            'password' => Hash::make('password'),
        ]);
    }
}

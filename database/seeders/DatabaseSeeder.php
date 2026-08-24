<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Order matters here: customers first, then addresses (which
     * need a customer_id), then orders (which need a customer_id
     * and an address_id), then wishlist items.
     *
     * NOTE: if your project already has a DatabaseSeeder with other
     * seeders in it (for the public website / admin module), just
     * add these four lines into your existing call() method instead
     * of replacing the whole file.
     */
    public function run(): void
    {
        $this->call([
            ProductSeeder::class,
            CustomerSeeder::class,
            AddressSeeder::class,
            OrderSeeder::class,
            WishlistSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    /**
     * Saves a couple of products to each customer's wishlist.
     */
    public function run(): void
    {
        $sampleProducts = [
            ['name' => 'Round Frame Sunglasses', 'image' => 'p7.webp', 'price' => 79.00],
            ['name' => 'Silk Printed Scarf',      'image' => 'p8.webp', 'price' => 45.00],
            ['name' => 'Suede Ankle Boots',       'image' => 'p9.webp', 'price' => 159.00],
        ];

        foreach (Customer::all() as $customer) {
            foreach ($sampleProducts as $product) {
                Wishlist::create([
                    'customer_id'   => $customer->id,
                    'product_name'  => $product['name'],
                    'product_image' => $product['image'],
                    'price'         => $product['price'],
                ]);
            }
        }
    }
}

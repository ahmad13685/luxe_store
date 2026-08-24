<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Creates a handful of orders (with products inside them) for
     * every seeded customer, using a mix of statuses so the
     * dashboard stat cards (Pending / Delivered) have real numbers
     * to show right after seeding.
     */
    public function run(): void
    {
        // A few sample products to pick from - reusing the images
        // that already exist in public/pic on the public website.
        $sampleProducts = [
            ['name' => 'Leather Tote Bag',      'image' => 'p1.webp',  'price' => 189.00],
            ['name' => 'Chronograph Watch',      'image' => 'p2.webp',  'price' => 249.00],
            ['name' => 'Minimal Sneakers',       'image' => 'p3.webp',  'price' => 129.00],
            ['name' => 'Classic Leather Wallet', 'image' => 'p4.webp',  'price' => 59.00],
            ['name' => 'Signature Perfume 50ml', 'image' => 'p5.webp',  'price' => 89.00],
            ['name' => 'Structured Backpack',    'image' => 'p6.webp',  'price' => 139.00],
        ];

        // One order per status, per customer, so every status shows
        // up somewhere in the seeded data.
        $statuses = Order::statusSteps();

        foreach (Customer::all() as $customer) {
            $address = Address::where('customer_id', $customer->id)->first();

            foreach ($statuses as $index => $status) {
                $order = Order::create([
                    'customer_id'          => $customer->id,
                    'status'                => $status,
                    'payment_method'        => $index % 2 === 0 ? 'Cash on Delivery' : 'Credit / Debit Card',
                    'shipping_address_id'   => $address?->id,
                    'billing_address_id'    => $address?->id,
                    'subtotal'              => 0, // filled in below once we know the items
                    'shipping_fee'          => 8.00,
                    'total_amount'          => 0,
                ]);

                // Give each order 1-3 random products
                $itemCount = random_int(1, 3);
                $subtotal = 0;

                for ($i = 0; $i < $itemCount; $i++) {
                    $product  = $sampleProducts[array_rand($sampleProducts)];
                    $quantity = random_int(1, 2);
                    $lineTotal = $product['price'] * $quantity;
                    $subtotal += $lineTotal;

                    OrderItem::create([
                        'order_id'       => $order->id,
                        'product_name'   => $product['name'],
                        'product_image'  => $product['image'],
                        'quantity'       => $quantity,
                        'unit_price'     => $product['price'],
                        'subtotal'       => $lineTotal,
                    ]);
                }

                // Now that we know the real subtotal, update the order totals
                $order->update([
                    'subtotal'     => $subtotal,
                    'total_amount' => $subtotal + $order->shipping_fee,
                ]);
            }
        }
    }
}

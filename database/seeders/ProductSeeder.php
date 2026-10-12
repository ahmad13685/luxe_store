<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Every product card that appears on the Home page and the Shop page,
     * with its real name / image / price / category, so the dynamic
     * product-details page always shows correct, matching data.
     *
     * IMPORTANT: order matters, and IDs must start clean at 1. Both
     * home.blade.php and shop.blade.php hardcode the numeric product ID
     * in their "View" links (route('customer.product-details', N)), so
     * this seeder wipes any old/leftover product rows first and inserts
     * fresh — otherwise old rows from a previous seeder run keep their
     * old IDs and every link below ends up pointing at the wrong product.
     */
    public function run(): void
    {
        // Keep admin categories in sync with the legacy string categories.
        $categoryCodes = [
            'Fashion' => '01',
            'Bags' => '02',
            'Watches' => '03',
            'Shoes' => '04',
            'Accessories' => '05',
            'Home Decor' => '06',
            'Beauty' => '07',
            'Stationery' => '08',
        ];

        foreach ($categoryCodes as $name => $code) {
            Category::updateOrCreate(['name' => $name], ['code' => $code]);
        }

        Schema::disableForeignKeyConstraints();
        ProductImage::truncate();
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        $products = [
            // ----- Home page: "New Arrivals" -----
            [
                'name' => 'Printed Silk Scarf',
                'description' => 'Elegant printed silk scarf with a premium soft finish, finished with hand-rolled edges.',
                'image' => 'pic/scarf.webp',
                'gallery' => ['pic/scarf.webp', 'pic/scarf2.webp', 'pic/scarf3.webp', 'pic/scarf4.webp'],
                'price' => 45,
                'category' => 'Fashion',
                'stock' => 30,
            ],
            [
                'name' => 'Structured Leather Tote',
                'description' => 'Premium structured leather tote designed for everyday elegance and durability.',
                'image' => 'pic/bag.webp',
                'price' => 210,
                'category' => 'Bags',
                'stock' => 15,
            ],
            [
                'name' => 'Minimal Steel Watch',
                'description' => 'Minimal luxury steel watch with a timeless design, on sale for a limited time.',
                'image' => 'pic/p10.webp',
                'price' => 499,
                'category' => 'Watches',
                'stock' => 12,
            ],
            [
                'name' => 'Suede Loafers',
                'description' => 'Soft suede loafers built for all-day comfort with a refined silhouette.',
                'image' => 'pic/p11.webp',
                'price' => 168,
                'category' => 'Shoes',
                'stock' => 18,
            ],

            // ----- Home page: "Best Sellers" -----
            [
                'name' => 'Tailored Wool Coat',
                'description' => 'A tailored wool coat cut for a sharp, structured silhouette in colder months.',
                'image' => 'pic/p1.webp',
                'price' => 498,
                'category' => 'Fashion',
                'stock' => 10,
            ],
            [
                'name' => 'Gold Hoop Earrings',
                'description' => '18k gold-plated hoop earrings with a lightweight, comfortable fit.',
                'image' => 'pic/p2.webp',
                'price' => 642,
                'category' => 'Accessories',
                'stock' => 40,
            ],
            [
                'name' => 'Sculpted Ceramic Vase',
                'description' => 'A hand-sculpted ceramic vase that brings a modern, minimal accent to any room.',
                'image' => 'pic/p3.webp',
                'price' => 74,
                'category' => 'Home Decor',
                'stock' => 22,
            ],
            [
                'name' => 'Radiance Face Serum',
                'description' => 'A lightweight radiance serum formulated to brighten and hydrate the skin.',
                'image' => 'pic/p4.webp',
                'price' => 38,
                'category' => 'Beauty',
                'stock' => 50,
            ],
            [
                'name' => 'Leather Bound Journal',
                'description' => 'A premium leather-bound journal with thick, smooth pages for everyday writing.',
                'image' => 'pic/p5.webp',
                'price' => 32,
                'category' => 'Stationery',
                'stock' => 35,
            ],
            [
                'name' => 'Canvas Travel Backpack',
                'description' => 'A durable canvas travel backpack with padded compartments for everyday carry.',
                'image' => 'pic/p6.webp',
                'price' => 139,
                'category' => 'Bags',
                'stock' => 20,
            ],
            [
                'name' => 'Classic Chelsea Boots',
                'description' => 'Classic Chelsea boots crafted from premium leather with an elastic side panel.',
                'image' => 'pic/p7.webp',
                'price' => 189,
                'category' => 'Shoes',
                'stock' => 16,
            ],
            [
                'name' => 'Signature Eau de Parfum',
                'description' => 'A signature eau de parfum with warm, lingering notes for everyday wear.',
                'image' => 'pic/p8.webp',
                'price' => 95,
                'category' => 'Beauty',
                'stock' => 28,
            ],
            [
                'name' => 'Linen Throw Cushion',
                'description' => 'A soft linen throw cushion that adds texture and comfort to any living space.',
                'image' => 'pic/p9.webp',
                'price' => 29,
                'category' => 'Home Decor',
                'stock' => 45,
            ],

            // ----- Shop page: "Shop All Products" -----
            [
                'name' => 'Oversized Linen Shirt',
                'description' => 'A relaxed, oversized linen shirt perfect for warm-weather layering.',
                'image' => 'pic/p1.webp',
                'price' => 68,
                'category' => 'Fashion',
                'stock' => 26,
            ],
            [
                'name' => 'Leather Ankle Boots',
                'description' => 'Leather ankle boots with a sturdy sole, built for everyday wear.',
                'image' => 'pic/p2.webp',
                'price' => 175,
                'category' => 'Shoes',
                'stock' => 14,
            ],
            [
                'name' => 'Chronograph Steel Watch',
                'description' => 'A chronograph steel watch with a precise movement and durable steel band.',
                'image' => 'pic/p4.webp',
                'price' => 289,
                'category' => 'Watches',
                'stock' => 6,
            ],
            [
                'name' => 'Matte Velvet Lipstick',
                'description' => 'A long-wearing matte velvet lipstick with rich, full-coverage pigment.',
                'image' => 'pic/p5.webp',
                'price' => 22,
                'category' => 'Beauty',
                'stock' => 60,
            ],
            [
                'name' => 'Classic Silk Tie',
                'description' => 'A classic silk tie with a fine weave, suited for formal occasions.',
                'image' => 'pic/p6.webp',
                'price' => 42,
                'category' => 'Accessories',
                'stock' => 33,
            ],
            [
                'name' => 'Ceramic Table Lamp',
                'description' => 'A ceramic table lamp with a soft, warm glow that suits any interior style.',
                'image' => 'pic/p7.webp',
                'price' => 88,
                'category' => 'Home Decor',
                'stock' => 19,
            ],
            [
                'name' => 'Kraft Notebook Set',
                'description' => 'A set of kraft-cover notebooks with recycled, lined pages for daily notes.',
                'image' => 'pic/p8.webp',
                'price' => 18,
                'category' => 'Stationery',
                'stock' => 55,
            ],
            [
                'name' => 'Round Frame Sunglasses',
                'description' => 'Round frame sunglasses with UV-protective lenses and a lightweight frame.',
                'image' => 'pic/p9.webp',
                'price' => 56,
                'category' => 'Accessories',
                'stock' => 24,
            ],
        ];

        foreach ($products as $product) {
            $record = Product::updateOrCreate(
                ['name' => $product['name']],
                [
                    'slug' => Str::slug($product['name']),
                    'description' => $product['description'],
                    'image' => $product['image'],
                    'price' => $product['price'],
                    'category_id' => Category::where('name', $product['category'])->value('id'),
                    'stock' => $product['stock'],
                    'is_active' => true,
                ]
            );

            // Gallery images, where a product has more than one real photo.
            if (!empty($product['gallery'])) {
                $record->images()->delete();

                foreach ($product['gallery'] as $index => $galleryImage) {
                    ProductImage::create([
                        'product_id' => $record->id,
                        'image' => $galleryImage,
                        'sort_order' => $index,
                    ]);
                }
            }
        }
    }
}

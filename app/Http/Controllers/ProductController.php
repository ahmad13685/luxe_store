<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        // Load the product's gallery images
        $product->load('images');

        // Related products from the same category
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->when(
                $product->category,
                function ($query) use ($product) {
                    $query->where('category', $product->category);
                }
            )
            ->latest()
            ->take(4)
            ->get();

        return view('product-details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}

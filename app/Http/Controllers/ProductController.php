<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->latest()
            ->take(4)
            ->get();

        $newArrivals = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        // There is no sales-count column in the current products table, so
        // use products with the highest stock as a stable fallback ordering.
        $bestSellers = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->orderByDesc('stock')
            ->latest()
            ->take(4)
            ->get();

        $wishlistMap = $this->wishlistMap();

        return view('home', compact(
            'featuredProducts',
            'newArrivals',
            'bestSellers',
            'wishlistMap'
        ));
    }

    public function index(Request $request)
    {
        $products = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim($request->string('q')->toString());

                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($term) {
                            $categoryQuery->where('name', 'like', "%{$term}%");
                        });
                });
            })
            ->latest()
            ->get();

        $categories = Category::query()
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->orderBy('name')
            ->get();

        $maxPrice = max(500, (int) ceil((float) (Product::where('is_active', true)->max('price') ?? 0)));

        $wishlistMap = $this->wishlistMap();

        return view('shop', compact(
            'products',
            'categories',
            'maxPrice',
            'wishlistMap'
        ));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load(['images', 'category']);

        $relatedProducts = Product::query()
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->with('category')
            ->when($product->category_id, function ($query) use ($product) {
                $query->where('category_id', $product->category_id);
            }, function ($query) use ($product) {
                $query->where('category', $product->getRawOriginal('category'));
            })
            ->latest()
            ->take(4)
            ->get();

        return view('product-details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    /**
     * Polled by the storefront (see public/js/product-image-sync.js) so a
     * customer already viewing a page picks up an image an admin just
     * changed, without a manual refresh. Only active products are
     * reported; anything else falls back to the placeholder on the client.
     */
    public function imageStatus(Request $request)
    {
        $ids = collect(explode(',', (string) $request->query('ids', '')))
            ->map(fn ($id) => (int) trim($id))
            ->filter()
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return response()->json([]);
        }

        $status = Product::query()
            ->where('is_active', true)
            ->whereIn('id', $ids)
            ->get(['id', 'image', 'updated_at'])
            ->mapWithKeys(fn (Product $product) => [
                $product->id => [
                    'image_url' => $product->image_url,
                    'version' => optional($product->updated_at)->timestamp,
                ],
            ]);

        return response()->json($status);
    }

    private function wishlistMap(): array
    {
        if (!session('customer_id')) {
            return [];
        }

        return \App\Models\Wishlist::where('customer_id', session('customer_id'))
            ->pluck('id', 'product_name')
            ->toArray();
    }
}

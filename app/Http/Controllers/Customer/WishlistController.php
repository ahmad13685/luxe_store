<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Show the logged-in customer's wishlist.
     */
    public function index()
    {
        $customer = Customer::findOrFail(session('customer_id'));

        $wishlist = $customer->wishlist()
            ->latest()
            ->get();

        // The wishlist row only stores a copy of the product name/image/price
        // (no product_id column), so match it back to the products table here
        // to get a real product id for the "View Product" link.
        $wishlist->each(function ($item) {
            $item->product_id = Product::where('name', $item->product_name)
                ->value('id');
        });

        return view('customer.wishlist', [
            'customer' => $customer,
            'wishlist' => $wishlist,
        ]);
    }

    /**
     * Add a product to wishlist.
     */
   public function store(Request $request)
{
    $customerId = session('customer_id');

    $request->validate([
        'product_name'  => 'required|string',
        'product_image' => 'nullable|string',
        'price'         => 'required|numeric',
    ]);

    $exists = Wishlist::where('customer_id', $customerId)
        ->where('product_name', $request->product_name)
        ->first();

    if ($exists) {
        if ($request->wantsJson()) {
            return response()->json([
                'status'  => 'exists',
                'id'      => $exists->id,
                'message' => 'Product is already in your wishlist.',
            ]);
        }
        return back()->with('info', 'Product is already in your wishlist.');
    }

    $item = Wishlist::create([
        'customer_id'   => $customerId,
        'product_name'  => $request->product_name,
        'product_image' => $request->product_image,
        'price'         => $request->price,
    ]);

    if ($request->wantsJson()) {
        return response()->json([
            'status'  => 'added',
            'id'      => $item->id,
            'message' => 'Product added to your wishlist.',
        ]);
    }

    return back()->with('success', 'Product added to your wishlist.');
}
    /**
     * Remove a wishlist item.
     */
    public function destroy(Request $request, $id)
    {
        $customer = Customer::findOrFail(session('customer_id'));

        $wishlistItem = $customer->wishlist()->findOrFail($id);

        $wishlistItem->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'status'  => 'removed',
                'message' => 'Product removed from your wishlist.',
            ]);
        }

        return back()->with('success', 'Product removed from your wishlist.');
    }
}

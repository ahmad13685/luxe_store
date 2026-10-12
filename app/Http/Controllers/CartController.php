<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * The public shop's cart is entirely client-side (localStorage,
 * see public/js/script.js - key "luxe-cart"). There is no Products
 * table, so items are described inline: { id, name, price, image, qty }.
 *
 * The server-side checkout (OrderController) reads its cart from
 * the PHP session under the "cart" key, shaped as:
 * [{ name, price, quantity, image }, ...]
 *
 * This controller is the bridge between the two: the "Proceed to
 * Checkout" button on the cart page posts the current localStorage
 * cart here before redirecting to /customer/checkout.
 */
class CartController extends Controller
{
    public function sync(Request $request)
    {
        $validated = $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.name' => 'required|string',
            'cart.*.price' => 'required|numeric|min:0',
            'cart.*.qty' => 'required|integer|min:1',
            'cart.*.image' => 'nullable|string',
        ]);

        // Re-key qty -> quantity to match what OrderController expects.
        // "image" is the src the product card/details page was using
        // (an absolute URL from asset()) - stored as-is so the order
        // can show the same picture later without needing a Products table.
        $cart = array_map(function ($item) {
            return [
                'name' => $item['name'],
                'price' => (float) $item['price'],
                'quantity' => (int) $item['qty'],
                'image' => $item['image'] ?? null,
            ];
        }, $validated['cart']);

        $request->session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }
}

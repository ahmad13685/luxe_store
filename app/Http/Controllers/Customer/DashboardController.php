<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * Show the Dashboard Home page: stat cards + recent orders table.
     *
     * The logged-in customer's ID is read straight from the session,
     * which is set by AuthController@login / AuthController@register.
     * The "customer.auth" middleware already guarantees this route
     * can't be reached without a session, so findOrFail() here is safe.
     */
    public function index()
    {
        $customer = Customer::findOrFail(session('customer_id'));

        // ---- Stat cards -------------------------------------------------
        $totalOrders = Order::where('customer_id', $customer->id)->count();

        $pendingOrders = Order::where('customer_id', $customer->id)
            ->where('status', Order::STATUS_PENDING)
            ->count();

        $deliveredOrders = Order::where('customer_id', $customer->id)
            ->where('status', Order::STATUS_DELIVERED)
            ->count();

        $wishlistItems = $customer->wishlist()->count();

        // ---- Recent orders table (latest 5) ------------------------------
        $recentOrders = Order::where('customer_id', $customer->id)
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        // ---- Wishlist preview (latest 4, for the little product row) ----
        $wishlistPreview = $customer->wishlist()->latest()->take(4)->get();

        // ---- Order status breakdown (powers the progress bars in the
        // sidebar panel) - real percentages out of the customer's own
        // orders, not fake/decorative numbers.
        $shippingCount = Order::where('customer_id', $customer->id)
            ->whereIn('status', [
                Order::STATUS_DISPATCHED,
                Order::STATUS_OUT_FOR_DELIVERY,
            ])
            ->count();

        // Avoid dividing by zero when a brand-new customer has no orders yet
        $orderProgress = [
            'pending'    => $totalOrders ? round(($pendingOrders / $totalOrders) * 100) : 0,
            'in_transit' => $totalOrders ? round(($shippingCount / $totalOrders) * 100) : 0,
            'delivered'  => $totalOrders ? round(($deliveredOrders / $totalOrders) * 100) : 0,
        ];

        return view('customer.dashboard', [
            'customer'         => $customer,
            'totalOrders'      => $totalOrders,
            'pendingOrders'    => $pendingOrders,
            'deliveredOrders'  => $deliveredOrders,
            'wishlistItems'    => $wishlistItems,
            'recentOrders'     => $recentOrders,
            'wishlistPreview'  => $wishlistPreview,
            'orderProgress'    => $orderProgress,
        ]);
    }
}

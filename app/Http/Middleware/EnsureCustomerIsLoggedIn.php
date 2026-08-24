<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * A simple, beginner-friendly "am I logged in" check.
 *
 * We are NOT using Laravel's built-in auth guards, Sanctum, or
 * Breeze here - the project only needs a plain session value.
 * When a customer logs in (Module 2) we will store their ID with:
 *
 *     session(['customer_id' => $customer->id]);
 *
 * This middleware just checks that value exists before letting
 * the request continue to any dashboard page.
 */
class EnsureCustomerIsLoggedIn
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('customer_id')) {
            // Remember where they were headed (e.g. /customer/checkout) so
            // AuthController@login can send them straight back after they
            // sign in, instead of always dropping them on the dashboard.
            $request->session()->put('url.intended', $request->fullUrl());

            // Plain URL (not route()) on purpose: the named "customer.login"
            // route is only added in Module 2, and route() would throw an
            // error if that name doesn't exist yet. Once Module 2 is in
            // place you can swap this for route('customer.login') if you
            // prefer - either way it points to the same page.
            return redirect('/customer/login')->with('error', 'Please login to access your dashboard.');
        }

        return $next($request);
    }
}

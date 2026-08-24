<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Handles Login, Register, Forgot Password and Logout for customers.
 *
 * Kept intentionally simple (no auth guards, no Sanctum/Breeze) - just
 * plain sessions, exactly like the rest of the Customer Dashboard module.
 */
class AuthController extends Controller
{
    // ================================================================
    // LOGIN
    // ================================================================

    /** Show the login form. */
    public function showLogin()
    {
        // If already logged in, no need to see the login page again
        if (session()->has('customer_id')) {
            return redirect('/customer/dashboard');
        }

        return view('customer.auth.login');
    }

    /** Handle the login form submission. */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $validated['email'])->first();

        // Same generic error whether the email or the password was wrong -
        // this is a small security habit worth learning: it doesn't tell
        // an attacker which part was incorrect.
        if (! $customer || ! Hash::check($validated['password'], $customer->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Invalid email or password.');
        }

        // Log the customer in - just a session value, nothing fancier
        $request->session()->put('customer_id', $customer->id);
        $request->session()->regenerate(); // security best practice: rotate session ID on login

        // If they were bounced here from a protected page (e.g. checkout),
        // send them back to it instead of always landing on the dashboard.
        // Otherwise (a normal, direct login) the customer should land on
        // their dashboard - not the public homepage.
        $intended = $request->session()->pull('url.intended', route('customer.dashboard'));

        return redirect($intended)->with('success', 'Welcome back, ' . $customer->name . '!');
    }

    // ================================================================
    // REGISTER
    // ================================================================

    /** Show the registration form. */
    public function showRegister()
    {
        if (session()->has('customer_id')) {
            return redirect('/customer/dashboard');
        }

        return view('customer.auth.register');
    }

    /** Handle the registration form submission. */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6|confirmed', // needs password_confirmation field
            'terms'    => 'required', // must tick the checkbox
        ], [
            'terms.required' => 'You must agree to the Terms & Conditions.',
        ]);

        $customer = Customer::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Do NOT log the customer in automatically here. The expected flow is
        // Register -> Customer Login -> Customer Dashboard, so send them to
        // the login page instead of establishing a session and skipping it.
        return redirect()->route('customer.login')
            ->with('success', 'Account created! Please sign in to continue, ' . $customer->name . '.');
    }

    // ================================================================
    // FORGOT PASSWORD
    // (Simplified: no email sending required - see note in the Blade
    // view for why. Confirms the email exists, then sets a new password
    // directly.)
    // ================================================================

    /** Show the forgot password form. */
    public function showForgotPassword()
    {
        return view('customer.auth.forgot-password');
    }

    /** Handle the forgot password form submission. */
    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::where('email', $validated['email'])->first();

        if (! $customer) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'We could not find an account with that email.');
        }

        $customer->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect('/customer/login')->with('success', 'Password updated! You can now sign in.');
    }

    // ================================================================
    // LOGOUT
    // ================================================================

    public function logout(Request $request)
    {
        $request->session()->forget('customer_id');
        $request->session()->regenerate();

        return redirect('')->with('success', 'You have been logged out.');
    }
}

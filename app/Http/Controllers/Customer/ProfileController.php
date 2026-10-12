<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $customer = Customer::findOrFail(session('customer_id'));

        return view('customer.profile.edit', compact('customer'));
    }

    public function update(Request $request)
    {
        $customer = Customer::findOrFail(session('customer_id'));

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:30',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $customer->name = $validated['name'];
        $customer->email = $validated['email'];
        $customer->phone = $validated['phone'] ?? null;

        if ($request->hasFile('profile_photo')) {
            $directory = public_path('pic/customers');

            if (! File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            if ($customer->profile_photo) {
                $oldPhoto = $directory . DIRECTORY_SEPARATOR . $customer->profile_photo;
                if (File::exists($oldPhoto)) {
                    File::delete($oldPhoto);
                }
            }

            $file = $request->file('profile_photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $customer->profile_photo = $filename;
        }

        $customer->save();

        return redirect()
            ->route('customer.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}

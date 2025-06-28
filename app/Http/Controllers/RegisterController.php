<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' =>  [
                'required',
                'string',
                // Password management (stronger requirements) using Laravel's built-in rules
                 Password::min(12)->mixedCase()->numbers()->symbols(),
                ],
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // Rainbow Table attack prevention
            'password' => Hash::make($validated['password']),
        ]);

        // Optionally log the user in
        auth()->login($user);

        return redirect('/')->with('success', 'Registration successful!');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginPageController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to log the user in using the 'username' (or 'email', depending on your Auth setup)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Prevent session fixation
            $user = Auth::user(); // Get the authenticated user

            // Redirect based on role
            if ($user->role === 'artist') {
                return redirect()->route('artist.commisions')->with('success', 'Welcome back, Artist!');
            }

            // Default redirect for 'client' and other roles
            return redirect()->route('home')->with('success', 'You are now logged in!');
        }

        // If login fails
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function register()
    {
        return view('register');
    }

    public function processRegister(Request $request)
    {
        // 1. Validation based on your registration form fields
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:members'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' checks against password_confirmation
            'line_id' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'instagram' => ['nullable', 'string', 'max:255'],
        ]);

        // 2. Create the new member (default role is 'client')
        $member = Member::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'line_id' => $validatedData['line_id'],
            'phone_number' => $validatedData['phone_number'],
            'instagram' => $validatedData['instagram'],
            'role' => 'client', // Default role for new registrations
        ]);

        // 3. Automatically log the new user in
        Auth::login($member);

        return redirect()->route('home')->with('success', 'Registration successful! Welcome aboard.');
    }
}

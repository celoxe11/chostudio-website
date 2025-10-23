<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginPageController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function processLogin(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Percobaan otentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Prevent session fixation
            $user = Auth::user(); // Get the authenticated user

            // Tentukan URL redirect berdasarkan peran
            $redirectUrl = ($user->role === 'artist')
                ? route('artist.commisions')
                : route('home');

            // Respons sukses untuk AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => $redirectUrl,
                    'message' => 'Login successful!'
                ]);
            }

            // Fallback untuk redirect standar
            return redirect()->to($redirectUrl)->with('success', 'Login successful!');
        }

        // 3. Otentikasi gagal
        $errorMessage = 'The current credentials do not match our records.';

        // Respons gagal untuk AJAX (Status 422 Unprocessable Entity)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 422);
        }

        // Fallback untuk redirect kembali dengan error standar
        return back()->withErrors([
            'username' => $errorMessage,
        ])->withInput();
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

    public function termsnconditions()
    {
        return view('terms_conditions');
    }
}

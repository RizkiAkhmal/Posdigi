<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Login
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login()
    {
        $credentials = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            
            // Redirect berdasarkan role
            if ($user->hasRole('admin')) {
                return redirect()->intended('admin/dashboard');
            } else {
                return redirect()->intended('user/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logout
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}



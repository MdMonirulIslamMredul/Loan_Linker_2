<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Your account is not active. Please contact support.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            // Redirect based on user role
            if ($user->isSuperAdmin()) {
                return redirect()->intended('/super-admin/dashboard');
            } elseif ($user->isBankAdmin()) {
                return redirect()->intended('/bank-admin/dashboard');
            } elseif ($user->isBranchAdmin()) {
                return redirect()->intended('/branch-admin/dashboard');
            } elseif (method_exists($user, 'isCustomer') && $user->isCustomer()) {
                return redirect()->intended('/customer/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

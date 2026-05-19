<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BankOfficerRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register_branch_admin');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone' => 'required|string|max:50',
            'nid_number' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'contact_address' => 'required|string|max:1000',
            'permanent_address' => 'required|string|max:1000',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'dob' => $data['dob'],
            'phone' => $data['phone'],
            'nid_number' => $data['nid_number'],
            'email' => $data['email'],
            'contact_address' => $data['contact_address'],
            'permanent_address' => $data['permanent_address'],
            'password' => Hash::make($data['password']),
            'role' => 'branch_admin',
            'is_access' => null,
            'access_mes' => null,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Bank officer registration successful.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register_customer');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'phone' => 'required|string|max:50',
            'dob' => 'required|date',
            'contact_address' => 'required|string|max:1000',
            'permanent_address' => 'required|string|max:1000',
            'education' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'organization_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'date_of_joining' => 'required|date',
            'total_working_experience' => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'dob' => $data['dob'],
            'contact_address' => $data['contact_address'],
            'permanent_address' => $data['permanent_address'],
            'education' => $data['education'],
            'profession' => $data['profession'],
            'organization_name' => $data['organization_name'],
            'designation' => $data['designation'],
            'date_of_joining' => $data['date_of_joining'],
            'total_working_experience' => $data['total_working_experience'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful.');
    }
}

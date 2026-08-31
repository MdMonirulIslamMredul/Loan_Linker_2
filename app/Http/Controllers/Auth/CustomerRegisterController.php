<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\Thana;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerRegisterController extends Controller
{
    protected function getLocationData(): array
    {
        $divisions = Division::orderBy('name')->pluck('name', 'id')->toArray();
        $districts = District::orderBy('name')
            ->get()
            ->groupBy('division_id')
            ->map(function ($group) {
                return $group->pluck('name', 'id')->toArray();
            })
            ->toArray();

        $thanas = Thana::orderBy('name')
            ->get()
            ->groupBy('district_id')
            ->map(function ($group) {
                return $group->pluck('name', 'id')->toArray();
            })
            ->toArray();

        return [
            'divisions' => $divisions,
            'districts' => $districts,
            'thanas' => $thanas,
        ];
    }

    public function showRegistrationForm()
    {
        $locationData = $this->getLocationData();

        return view('auth.register_customer', [
            'divisions' => $locationData['divisions'],
            'districts' => $locationData['districts'],
            'thanas' => $locationData['thanas'],
        ]);
    }

    public function register(Request $request)
    {
        $locationData = $this->getLocationData();
        $divisions = $locationData['divisions'];
        $districts = $locationData['districts'];
        $thanas = $locationData['thanas'];

        $data = $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => ['required', 'email', 'max:255', 'regex:/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.(com)$/i', Rule::unique('users', 'email')],
            'email' => ['required', 'email', 'max:255', 'regex:/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/i', Rule::unique('users', 'email')],

            'phone' => ['required', 'string', 'regex:/^01[0-9]{9}$/'],
            'dob' => 'required|date',
            'c_division_id' => ['required', 'integer', Rule::in(array_keys($divisions))],
            'c_district_id' => ['required', 'integer'],
            'c_thana_id' => ['required', 'integer'],
            'contact_address' => 'required|string|max:1000',
            'p_division_id' => ['required', 'integer', Rule::in(array_keys($divisions))],
            'p_district_id' => ['required', 'integer'],
            'p_thana_id' => ['required', 'integer'],
            'reference' => 'nullable|string|max:255',
            'permanent_address' => 'required|string|max:1000',
            'password' => 'required|string|min:8|confirmed',
            'accepted_terms' => 'accepted',
        ]);

        if (! isset($districts[$data['c_division_id']][$data['c_district_id']])) {
            return back()->withErrors(['c_district_id' => 'The selected contact district does not belong to the selected division.'])->withInput();
        }

        if (! isset($thanas[$data['c_district_id']][$data['c_thana_id']])) {
            return back()->withErrors(['c_thana_id' => 'The selected contact thana does not belong to the selected district.'])->withInput();
        }

        if (! isset($districts[$data['p_division_id']][$data['p_district_id']])) {
            return back()->withErrors(['p_district_id' => 'The selected permanent district does not belong to the selected division.'])->withInput();
        }

        if (! isset($thanas[$data['p_district_id']][$data['p_thana_id']])) {
            return back()->withErrors(['p_thana_id' => 'The selected permanent thana does not belong to the selected district.'])->withInput();
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'dob' => $data['dob'],
            'c_division_id' => $data['c_division_id'],
            'c_district_id' => $data['c_district_id'],
            'c_thana_id' => $data['c_thana_id'],
            'contact_address' => $data['contact_address'],
            'p_division_id' => $data['p_division_id'],
            'p_district_id' => $data['p_district_id'],
            'p_thana_id' => $data['p_thana_id'],
            'reference' => $data['reference'],
            'permanent_address' => $data['permanent_address'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'accepted_terms' => true,
            'terms_accepted_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful.');
    }
}

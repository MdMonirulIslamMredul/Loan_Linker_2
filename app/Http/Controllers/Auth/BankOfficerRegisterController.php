<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BankOfficerRegisterController extends Controller
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

        return [
            'divisions' => $divisions,
            'districts' => $districts,
        ];
    }

    public function showRegistrationForm()
    {
        $locationData = $this->getLocationData();
        $banks = \App\Models\Bank::where('is_active', true)->orderBy('name')->get();

        return view('auth.register_branch_admin', [
            'divisions' => $locationData['divisions'],
            'districts' => $locationData['districts'],
            'banks' => $banks,
        ]);
    }

    public function register(Request $request)
    {
        $locationData = $this->getLocationData();
        $divisions = $locationData['divisions'];
        $districts = $locationData['districts'];
        $banks = \App\Models\Bank::where('is_active', true)->orderBy('name')->get(); 

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone' => 'required|string|max:50',
            'nid_number' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'bank_id' => 'nullable|integer|exists:banks,id',
            'c_division_id' => ['required', 'integer', Rule::in(array_keys($divisions))],
            'c_district_id' => ['required', 'integer'],
            'contact_address' => 'required|string|max:1000',
            'p_division_id' => ['required', 'integer', Rule::in(array_keys($divisions))],
            'p_district_id' => ['required', 'integer'],
            'permanent_address' => 'required|string|max:1000',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (! isset($districts[$data['c_division_id']][$data['c_district_id']])) {
            return back()->withErrors(['c_district_id' => 'The selected contact district does not belong to the selected division.'])->withInput();
        }

        if (! isset($districts[$data['p_division_id']][$data['p_district_id']])) {
            return back()->withErrors(['p_district_id' => 'The selected permanent district does not belong to the selected division.'])->withInput();
        }

        $user = User::create([
            'name' => $data['name'],
            'dob' => $data['dob'],
            'phone' => $data['phone'],
            'nid_number' => $data['nid_number'],
            'email' => $data['email'],
            'c_division_id' => $data['c_division_id'],
            'c_district_id' => $data['c_district_id'],
            'contact_address' => $data['contact_address'],
            'p_division_id' => $data['p_division_id'],
            'p_district_id' => $data['p_district_id'],
            'permanent_address' => $data['permanent_address'],
            'password' => Hash::make($data['password']),
            'bank_id' => $data['bank_id'],
            'role' => 'branch_admin',
            'is_access' => null,
            'access_mes' => null,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Bank officer registration successful.');
    }
}

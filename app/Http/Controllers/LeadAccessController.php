<?php

namespace App\Http\Controllers;

use App\Models\LeadAccess;
use App\Models\LoanApplication;
use Illuminate\Http\Request;

class LeadAccessController extends Controller
{
    public function unlock(LoanApplication $application)
    {
        $user = auth()->user();

        // super admins and bank-admins can always see without unlocking
        if ($user->isSuperAdmin() || $user->isBankAdmin()) {
            return redirect()->back();
        }

        // check if already unlocked
        $exists = LeadAccess::where('officer_id', $user->id)
            ->where('application_id', $application->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('success', 'Lead already unlocked.');
        }

        // check balance
        if (($user->lead_balance ?? 0) <= 0) {
            return redirect()->back()->with('error', 'Insufficient lead balance. Please purchase a package.');
        }

        // deduct 1 and create access
        $user->lead_balance = $user->lead_balance - 1;
        $user->save();

        LeadAccess::create([
            'officer_id' => $user->id,
            'application_id' => $application->id,
            'purchased_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Lead unlocked and deducted from your balance.');
    }
}

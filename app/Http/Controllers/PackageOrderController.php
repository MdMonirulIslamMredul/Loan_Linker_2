<?php

namespace App\Http\Controllers;

use App\Models\PackageOrder;
use App\Models\LeadPackage;
use App\Models\User;
use App\Models\Bank;
use App\Models\Branch;
use Illuminate\Http\Request;

class PackageOrderController extends Controller
{
    // Super-admin: view orders
    public function index(Request $request)
    {
        $query = PackageOrder::with(['user', 'leadPackage']);

        // Filter by package
        if ($request->filled('package_id')) {
            $query->where('lead_package_id', $request->package_id);
        }

        // Filter by bank (via user)
        if ($request->filled('bank_id')) {
            $bankId = $request->bank_id;
            $query->whereHas('user', function ($q) use ($bankId) {
                $q->where('bank_id', $bankId);
            });
        }

        // Filter by branch (via user)
        if ($request->filled('branch_id')) {
            $branchId = $request->branch_id;
            $query->whereHas('user', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        // Filter by officer
        if ($request->filled('officer_id')) {
            $query->where('user_id', $request->officer_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter (order date)
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // show pending orders first, then newest orders
        $orders = $query->orderByRaw("status = 'pending' DESC")->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $packages = LeadPackage::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $banks = Bank::with('branches')->orderBy('name')->get();

        return view('super-admin.package-orders.index', compact('orders', 'packages', 'users', 'banks'));
    }

    // Super-admin: approve order
    public function approve(PackageOrder $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('success', 'Order already processed.');
        }

        $order->status = 'approved';
        $order->updated_by = auth()->id();
        $order->approved_at = now();
        // clear any previous rejection timestamp
        if (property_exists($order, 'rejected_at') || array_key_exists('rejected_at', $order->getAttributes())) {
            $order->rejected_at = null;
        }
        $order->save();

        // add leads to user's balance
        $user = $order->user;
        $user->lead_balance = ($user->lead_balance ?? 0) + $order->number_of_leads;
        $user->save();

        return redirect()->route('super-admin.package-orders.index')
            ->with('success', 'Order approved and leads added to officer balance.');
    }

    // Super-admin: reject order
    public function reject(PackageOrder $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('success', 'Order already processed.');
        }

        $order->status = 'rejected';
        // record which admin rejected the order
        $order->updated_by = auth()->id();
        $order->approved_at = null;
        // record rejection time if column exists
        if (property_exists($order, 'rejected_at') || array_key_exists('rejected_at', $order->getAttributes())) {
            $order->rejected_at = now();
        }
        $order->save();

        return redirect()->route('super-admin.package-orders.index')
            ->with('success', 'Order rejected.');
    }

    /**
     * Super-admin: show aggregated officer purchase stats ordered by total leads purchased.
     */
    public function officerPurchases(Request $request)
    {
        $query = \App\Models\User::query();

        // Optional bank/branch filters
        if ($request->filled('bank_id')) {
            $query->where('bank_id', $request->bank_id);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        // only include users who have approved package orders
        $query->whereHas('packageOrders', function ($q) {
            $q->where('status', 'approved');
        });

        $query->withCount(['packageOrders as orders_count' => function ($q) {
            $q->where('status', 'approved');
        }])->withSum(['packageOrders as total_leads' => function ($q) {
            $q->where('status', 'approved');
        }], 'number_of_leads')
            ->withSum(['packageOrders as total_spent' => function ($q) {
                $q->where('status', 'approved');
            }], 'price')
            // counts per package type (approved orders only)
            ->withCount([
                'packageOrders as regular_count' => function ($q) {
                    $q->where('status', 'approved')->whereHas('leadPackage', function ($q2) {
                        $q2->where('type', 'regular');
                    });
                },
                'packageOrders as premium_count' => function ($q) {
                    $q->where('status', 'approved')->whereHas('leadPackage', function ($q2) {
                        $q2->where('type', 'premium');
                    });
                },
                'packageOrders as gift_count' => function ($q) {
                    $q->where('status', 'approved')->whereHas('leadPackage', function ($q2) {
                        $q2->where('type', 'gift');
                    });
                },
            ]);

        $users = $query->orderByDesc('total_leads')->paginate(10)->withQueryString();

        $banks = \App\Models\Bank::with('branches')->orderBy('name')->get();

        return view('super-admin.package-orders.officer_purchases', compact('users', 'banks'));
    }

    /**
     * Show available gift packages to assign to a specific officer.
     */
    public function showGiftPackages(User $user)
    {
        $giftPackages = LeadPackage::where('type', 'gift')->orderBy('created_at', 'desc')->get();

        return view('super-admin.package-orders.gift_packages', compact('user', 'giftPackages'));
    }

    /**
     * Assign (gift) a package to an officer. Creates an approved PackageOrder and credits leads.
     */
    public function assignGift(Request $request, User $user)
    {
        $validated = $request->validate([
            'lead_package_id' => 'required|exists:lead_packages,id',
        ]);

        $package = LeadPackage::findOrFail($validated['lead_package_id']);

        $order = PackageOrder::create([
            'user_id' => $user->id,
            'lead_package_id' => $package->id,
            'price' => 0,
            'number_of_leads' => $package->number_of_leads,
            'status' => 'approved',
            'updated_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Credit leads to user's balance
        $user->lead_balance = ($user->lead_balance ?? 0) + $package->number_of_leads;
        $user->save();

        return redirect()->route('super-admin.package-orders.officer-purchases')
            ->with('success', 'Gift package assigned and leads credited to officer.');
    }
}

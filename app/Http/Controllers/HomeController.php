<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Loan;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        // Get active banks with their loans
        $banks = Bank::where('is_active', true)
            ->with(['branches.loans' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        // Get featured loans (latest active loans)
        $featuredLoans = Loan::where('is_active', true)
            ->with(['branch.bank', 'category'])
            ->latest()
            ->take(6)
            ->get();

        // Get all active loans for banners
        $bannerLoans = Loan::where('is_active', true)
            ->whereNotNull('banner')
            ->with(['branch.bank', 'category'])
            ->latest()
            ->take(5)
            ->get();

        // Get active testimonials
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact('banks', 'featuredLoans', 'bannerLoans', 'testimonials'));
    }

    /**
     * Search for loans.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $loans = Loan::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('details1', 'like', '%' . $query . '%')
                    ->orWhereHas('branch.bank', function($subQuery) use ($query) {
                        $subQuery->where('name', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('category', function($subQuery) use ($query) {
                        $subQuery->where('name', 'like', '%' . $query . '%');
                    });
            })
            ->with(['branch.bank', 'category'])
            ->paginate(12);

        return view('search-results', compact('loans', 'query'));
    }

    /**
     * Display all loans with filters.
     */
    public function allLoans(Request $request)
    {
        $bankId = $request->input('bank');
        $categoryId = $request->input('category');
        $loanName = $request->input('loan_name');

        // Get all active banks for filter dropdown
        $banks = Bank::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get all active loan categories for filter dropdown
        $categories = \App\Models\LoanCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Build query
        $loansQuery = Loan::where('is_active', true)
            ->with(['branch.bank', 'category']);

        // Apply bank filter
        if ($bankId) {
            $loansQuery->whereHas('branch.bank', function($query) use ($bankId) {
                $query->where('id', $bankId);
            });
        }

        // Apply category filter
        if ($categoryId) {
            $loansQuery->where('category_id', $categoryId);
        }

        // Apply loan name filter
        if ($loanName) {
            $loansQuery->where('name', 'like', '%' . $loanName . '%');
        }

        $loans = $loansQuery->latest()->paginate(12);

        return view('all-loans', compact('loans', 'banks', 'categories', 'bankId', 'categoryId', 'loanName'));
    }

    /**
     * Display all banks.
     */
    public function allBanks()
    {
        $banks = Bank::where('is_active', true)
            ->withCount(['branches'])
            ->with(['branches.loans' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name')
            ->paginate(12);

        return view('all-banks', compact('banks'));
    }

    /**
     * Display loan details.
     */
    public function show(Loan $loan)
    {
        // Load relationships
        $loan->load(['branch.bank', 'category']);

        return view('loan-details', compact('loan'));
    }
}

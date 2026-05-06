<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\BankAdminController;
use App\Http\Controllers\BranchAdminController;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\LoanCategoryController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\LogoSettingController;
use App\Http\Controllers\AboutSettingController;
use App\Http\Controllers\LeadPackageController;
use App\Http\Controllers\PackageOrderController;
use App\Http\Controllers\OfficerPurchaseController;
use App\Http\Controllers\LeadAccessController;
use App\Http\Controllers\Auth\CustomerRegisterController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/all-loans', [HomeController::class, 'allLoans'])->name('loans.all');
Route::get('/all-banks', [HomeController::class, 'allBanks'])->name('banks.all');
Route::get('/loans/{loan}', [HomeController::class, 'show'])->name('loans.show');
Route::get('/about-us', [AboutSettingController::class, 'show'])->name('about');
Route::get('/contact-us', [AboutSettingController::class, 'contact'])->name('contact');
Route::post('/contact-us', [AboutSettingController::class, 'submitContact'])->name('contact.send');

// Legal / static pages
Route::view('/privacy-policy', 'privacy_policy')->name('pages.privacy_policy');
Route::view('/terms-conditions', 'terms')->name('pages.terms');


Route::get('/services', function () {
    return view('services');
})->name('services');
Route::get('/loans/{loan}/apply', [LoanApplicationController::class, 'create'])->name('loans.apply')->middleware('auth');
Route::post('/loans/{loan}/apply', [LoanApplicationController::class, 'store'])->name('loans.apply.store')->middleware('auth');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer Registration (simple)
Route::get('/register-customer', [CustomerRegisterController::class, 'showRegistrationForm'])->name('register.customer');
Route::post('/register-customer', [CustomerRegisterController::class, 'register'])->name('register.customer.submit');

// Super Admin Routes
Route::middleware(['auth', 'super.admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');

    // Bank Management
    Route::get('/banks', [SuperAdminController::class, 'listBanks'])->name('super-admin.banks.index');
    Route::get('/banks/create', [SuperAdminController::class, 'createBank'])->name('super-admin.banks.create');
    Route::post('/banks', [SuperAdminController::class, 'storeBank'])->name('super-admin.banks.store');
    Route::get('/banks/{bank}/edit', [SuperAdminController::class, 'editBank'])->name('super-admin.banks.edit');
    Route::put('/banks/{bank}', [SuperAdminController::class, 'updateBank'])->name('super-admin.banks.update');
    Route::delete('/banks/{bank}', [SuperAdminController::class, 'destroyBank'])->name('super-admin.banks.destroy');

    // Bank Admin Management
    Route::get('/bank-admins', [SuperAdminController::class, 'listBankAdmins'])->name('super-admin.bank-admins.index');
    Route::get('/bank-admins/create', [SuperAdminController::class, 'createBankAdmin'])->name('super-admin.bank-admins.create');
    Route::post('/bank-admins', [SuperAdminController::class, 'storeBankAdmin'])->name('super-admin.bank-admins.store');
    Route::get('/bank-admins/{user}/edit', [SuperAdminController::class, 'editBankAdmin'])->name('super-admin.bank-admins.edit');
    Route::put('/bank-admins/{user}', [SuperAdminController::class, 'updateBankAdmin'])->name('super-admin.bank-admins.update');

    // Branch Management
    Route::get('/branches', [SuperAdminController::class, 'listBranches'])->name('super-admin.branches.index');
    Route::get('/branches/create', [SuperAdminController::class, 'createBranch'])->name('super-admin.branches.create');
    Route::post('/branches', [SuperAdminController::class, 'storeBranch'])->name('super-admin.branches.store');
    Route::get('/branches/{branch}/edit', [SuperAdminController::class, 'editBranch'])->name('super-admin.branches.edit');
    Route::put('/branches/{branch}', [SuperAdminController::class, 'updateBranch'])->name('super-admin.branches.update');
    Route::delete('/branches/{branch}', [SuperAdminController::class, 'destroyBranch'])->name('super-admin.branches.destroy');

    // Branch Admin Management
    Route::get('/branch-admins', [SuperAdminController::class, 'listBranchAdmins'])->name('super-admin.branch-admins.index');
    Route::get('/branch-admins/create', [SuperAdminController::class, 'createBranchAdmin'])->name('super-admin.branch-admins.create');
    Route::post('/branch-admins', [SuperAdminController::class, 'storeBranchAdmin'])->name('super-admin.branch-admins.store');
    Route::get('/branch-admins/{user}/edit', [SuperAdminController::class, 'editBranchAdmin'])->name('super-admin.branch-admins.edit');
    Route::put('/branch-admins/{user}', [SuperAdminController::class, 'updateBranchAdmin'])->name('super-admin.branch-admins.update');

    // Loan Management
    Route::get('/loans', [SuperAdminController::class, 'listLoans'])->name('super-admin.loans.index');
    Route::get('/loans/create', [SuperAdminController::class, 'createLoan'])->name('super-admin.loans.create');
    Route::post('/loans', [SuperAdminController::class, 'storeLoan'])->name('super-admin.loans.store');
    Route::get('/loans/{loan}/edit', [SuperAdminController::class, 'editLoan'])->name('super-admin.loans.edit');
    Route::put('/loans/{loan}', [SuperAdminController::class, 'updateLoan'])->name('super-admin.loans.update');
    Route::delete('/loans/{loan}', [SuperAdminController::class, 'destroyLoan'])->name('super-admin.loans.destroy');

    // Loan Category Management
    Route::get('/loan-categories', [LoanCategoryController::class, 'index'])->name('super-admin.loan-categories.index');
    Route::get('/loan-categories/create', [LoanCategoryController::class, 'create'])->name('super-admin.loan-categories.create');
    Route::post('/loan-categories', [LoanCategoryController::class, 'store'])->name('super-admin.loan-categories.store');
    Route::get('/loan-categories/{loanCategory}/edit', [LoanCategoryController::class, 'edit'])->name('super-admin.loan-categories.edit');
    Route::put('/loan-categories/{loanCategory}', [LoanCategoryController::class, 'update'])->name('super-admin.loan-categories.update');
    Route::delete('/loan-categories/{loanCategory}', [LoanCategoryController::class, 'destroy'])->name('super-admin.loan-categories.destroy');

    // Testimonials Management
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('super-admin.testimonials.index');
    Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('super-admin.testimonials.create');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('super-admin.testimonials.store');
    Route::get('/testimonials/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('super-admin.testimonials.edit');
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('super-admin.testimonials.update');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('super-admin.testimonials.destroy');

    // Lead Packages Management
    Route::get('/lead-packages', [LeadPackageController::class, 'index'])->name('super-admin.lead-packages.index');
    Route::get('/lead-packages/create', [LeadPackageController::class, 'create'])->name('super-admin.lead-packages.create');
    Route::post('/lead-packages', [LeadPackageController::class, 'store'])->name('super-admin.lead-packages.store');
    Route::get('/lead-packages/{leadPackage}/edit', [LeadPackageController::class, 'edit'])->name('super-admin.lead-packages.edit');
    Route::put('/lead-packages/{leadPackage}', [LeadPackageController::class, 'update'])->name('super-admin.lead-packages.update');
    Route::delete('/lead-packages/{leadPackage}', [LeadPackageController::class, 'destroy'])->name('super-admin.lead-packages.destroy');

    // Package Orders / Approvals
    Route::get('/package-orders', [PackageOrderController::class, 'index'])->name('super-admin.package-orders.index');
    Route::get('/officer-purchases', [PackageOrderController::class, 'officerPurchases'])->name('super-admin.package-orders.officer-purchases');
    Route::post('/package-orders/{order}/approve', [PackageOrderController::class, 'approve'])->name('super-admin.package-orders.approve');
    Route::post('/package-orders/{order}/reject', [PackageOrderController::class, 'reject'])->name('super-admin.package-orders.reject');

    // Gift packages for a specific officer (super-admin)
    Route::get('/officer-purchases/{user}/gift-packages', [PackageOrderController::class, 'showGiftPackages'])->name('super-admin.package-orders.gift.show');
    Route::post('/officer-purchases/{user}/gift-packages', [PackageOrderController::class, 'assignGift'])->name('super-admin.package-orders.gift.assign');

    // Logo Settings
    Route::get('/logo-settings', [LogoSettingController::class, 'index'])->name('super-admin.logo-settings.index');
    Route::put('/logo-settings', [LogoSettingController::class, 'update'])->name('super-admin.logo-settings.update');
    Route::delete('/logo-settings/{type}', [LogoSettingController::class, 'deleteLogo'])->name('super-admin.logo-settings.delete');

    // About Settings
    Route::get('/about-settings', [AboutSettingController::class, 'index'])->name('super-admin.about-settings.index');
    Route::put('/about-settings', [AboutSettingController::class, 'update'])->name('super-admin.about-settings.update');



    // Loan Applications Management
    Route::get('/applications', [LoanApplicationController::class, 'index'])->name('super-admin.applications.index');
    Route::get('/applications/{application}', [LoanApplicationController::class, 'show'])->name('super-admin.applications.show');
    Route::post('/applications/{application}/status', [LoanApplicationController::class, 'updateStatus'])->name('super-admin.applications.updateStatus');
    // Customers Management
    Route::get('/customers', [SuperAdminController::class, 'listCustomers'])->name('super-admin.customers.index');
    Route::post('/customers/{user}/reset-password', [SuperAdminController::class, 'resetCustomerPassword'])->name('super-admin.customers.reset-password');
    // Customer Messages Management
    Route::get('/customer-messages', [SuperAdminController::class, 'customerMessages'])->name('super-admin.customer-messages.index');
    Route::get('/customer-messages/{message}', [SuperAdminController::class, 'showCustomerMessage'])->name('super-admin.customer-messages.show');
    Route::post('/customer-messages/{message}/mark-read', [SuperAdminController::class, 'markMessageRead'])->name('super-admin.customer-messages.markRead');
    // Super-admin profile/password
    Route::get('/profile/password', [SuperAdminController::class, 'editPassword'])->name('super-admin.profile.password.edit');
    Route::put('/profile/password', [SuperAdminController::class, 'updatePassword'])->name('super-admin.profile.password');
});

// Bank Admin Routes
// API: Get branches for a bank (used by super-admin filters)
Route::get('/api/banks/{bank}/branches', function (App\Models\Bank $bank) {
    $branches = App\Models\Branch::where('bank_id', $bank->id)
        ->where('is_active', 1)
        ->select('id', 'name', 'code')
        ->get();

    return response()->json($branches);
})->name('api.bank.branches');

// API: Get branch-admin users for a branch
Route::get('/api/branches/{branch}/admins', function (App\Models\Branch $branch) {
    $admins = App\Models\User::where('branch_id', $branch->id)
        ->where('role', 'branch_admin')
        ->where('is_active', 1)
        ->select('id', 'name')
        ->get();

    return response()->json($admins);
})->name('api.branch.admins');

Route::middleware(['auth', 'bank.admin'])->prefix('bank-admin')->group(function () {
    Route::get('/dashboard', [BankAdminController::class, 'dashboard'])->name('bank-admin.dashboard');

    // Branch Management
    Route::get('/branches', [BankAdminController::class, 'listBranches'])->name('bank-admin.branches.index');
    Route::get('/branches/create', [BankAdminController::class, 'createBranch'])->name('bank-admin.branches.create');
    Route::post('/branches', [BankAdminController::class, 'storeBranch'])->name('bank-admin.branches.store');
    Route::get('/branches/{branch}/edit', [BankAdminController::class, 'editBranch'])->name('bank-admin.branches.edit');
    Route::put('/branches/{branch}', [BankAdminController::class, 'updateBranch'])->name('bank-admin.branches.update');
    Route::delete('/branches/{branch}', [BankAdminController::class, 'destroyBranch'])->name('bank-admin.branches.destroy');

    // Branch Admin Management
    Route::get('/branch-admins', [BankAdminController::class, 'listBranchAdmins'])->name('bank-admin.branch-admins.index');
    Route::get('/branch-admins/create', [BankAdminController::class, 'createBranchAdmin'])->name('bank-admin.branch-admins.create');
    Route::post('/branch-admins', [BankAdminController::class, 'storeBranchAdmin'])->name('bank-admin.branch-admins.store');
    Route::get('/branch-admins/{user}/edit', [BankAdminController::class, 'editBranchAdmin'])->name('bank-admin.branch-admins.edit');
    Route::put('/branch-admins/{user}', [BankAdminController::class, 'updateBranchAdmin'])->name('bank-admin.branch-admins.update');

    // Loan Management (bank-wide across branches)
    Route::get('/loans', [App\Http\Controllers\BankAdminController::class, 'indexLoans'])->name('bank-admin.loans.index');
    Route::get('/loans/create', [App\Http\Controllers\BankAdminController::class, 'createLoan'])->name('bank-admin.loans.create');
    Route::post('/loans', [App\Http\Controllers\BankAdminController::class, 'storeLoan'])->name('bank-admin.loans.store');
    Route::get('/loans/{loan}/edit', [App\Http\Controllers\BankAdminController::class, 'editLoan'])->name('bank-admin.loans.edit');
    Route::put('/loans/{loan}', [App\Http\Controllers\BankAdminController::class, 'updateLoan'])->name('bank-admin.loans.update');
    Route::delete('/loans/{loan}', [App\Http\Controllers\BankAdminController::class, 'destroyLoan'])->name('bank-admin.loans.destroy');

    // Loan Applications Management (bank-level)
    Route::get('/applications', [App\Http\Controllers\BankAdminController::class, 'applications'])->name('bank-admin.applications.index');
    Route::get('/applications/{application}', [App\Http\Controllers\BankAdminController::class, 'showApplication'])->name('bank-admin.applications.show');
    Route::post('/applications/{application}/status', [App\Http\Controllers\BankAdminController::class, 'updateApplicationStatus'])->name('bank-admin.applications.updateStatus');
});

// Officer / Branch Admin package gallery & purchase
Route::middleware(['auth', 'branch.admin'])->prefix('branch-admin')->group(function () {
    Route::get('/packages', [OfficerPurchaseController::class, 'gallery'])->name('branch-admin.packages.gallery');
    Route::get('/packages/{leadPackage}/purchase', [OfficerPurchaseController::class, 'showPurchaseForm'])->name('branch-admin.packages.purchase.form');
    Route::post('/packages/{leadPackage}/purchase', [OfficerPurchaseController::class, 'purchase'])->name('branch-admin.packages.purchase');

    // Unlock lead for a specific application
    Route::post('/applications/{application}/unlock', [LeadAccessController::class, 'unlock'])->name('branch-admin.applications.unlock');
    Route::get('/packages/history', [OfficerPurchaseController::class, 'history'])->name('branch-admin.packages.history');
});

// Branch Admin Routes
Route::middleware(['auth', 'branch.admin'])->prefix('branch-admin')->group(function () {
    Route::get('/dashboard', [BranchAdminController::class, 'dashboard'])->name('branch-admin.dashboard');

    // Loan Management
    Route::get('/loans', [BranchAdminController::class, 'indexLoans'])->name('branch-admin.loans.index');
    Route::get('/loans/create', [BranchAdminController::class, 'createLoan'])->name('branch-admin.loans.create');
    Route::post('/loans', [BranchAdminController::class, 'storeLoan'])->name('branch-admin.loans.store');
    Route::get('/loans/{loan}/edit', [BranchAdminController::class, 'editLoan'])->name('branch-admin.loans.edit');
    Route::put('/loans/{loan}', [BranchAdminController::class, 'updateLoan'])->name('branch-admin.loans.update');
    Route::delete('/loans/{loan}', [BranchAdminController::class, 'destroyLoan'])->name('branch-admin.loans.destroy');

    // Loan Applications Management
    Route::get('/applications', [LoanApplicationController::class, 'branchApplications'])->name('branch-admin.applications.index');
    Route::get('/applications/{application}', [LoanApplicationController::class, 'branch_show'])->name('branch-admin.applications.show');
    Route::post('/applications/{application}/status', [LoanApplicationController::class, 'updateStatus'])->name('branch-admin.applications.updateStatus');
    // Branch admin profile & password
    Route::get('/profile', [App\Http\Controllers\BranchAdminController::class, 'profile'])->name('branch-admin.profile');
    Route::get('/profile/edit', [App\Http\Controllers\BranchAdminController::class, 'editProfile'])->name('branch-admin.profile.edit');
    Route::put('/profile', [App\Http\Controllers\BranchAdminController::class, 'updateProfile'])->name('branch-admin.profile.update');
    Route::get('/profile/password', [App\Http\Controllers\BranchAdminController::class, 'editPassword'])->name('branch-admin.profile.password.edit');
    Route::put('/profile/password', [App\Http\Controllers\BranchAdminController::class, 'updatePassword'])->name('branch-admin.profile.password');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Customer\CustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('/profile', [App\Http\Controllers\Customer\CustomerController::class, 'profile'])->name('customer.profile');
    Route::get('/profile/edit', [App\Http\Controllers\Customer\CustomerController::class, 'editProfile'])->name('customer.profile.edit');
    Route::get('/profile/password', [App\Http\Controllers\Customer\CustomerController::class, 'editPassword'])->name('customer.profile.password.edit');
    Route::put('/profile', [App\Http\Controllers\Customer\CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Customer\CustomerController::class, 'updatePassword'])->name('customer.profile.password');
    Route::get('/applications', [App\Http\Controllers\Customer\CustomerController::class, 'applications'])->name('customer.applications');
    // additional customer panel routes can be added here under App\Http\Controllers\Customer namespace
});

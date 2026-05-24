<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bank_id',
        'branch_id',
        'phone',
        'nid_number',
        'dob',
        'c_division_id',
        'c_district_id',
        'p_division_id',
        'p_district_id',
        'contact_address',
        'permanent_address',
        'education',
        'profession',
        'organization_name',
        'designation',
        'date_of_joining',
        'total_working_experience',
        'lead_balance',
        'customer_document_id',
        'customer_financial_id',
        'bank_official_id',
        'officer_document_id',
        'is_active',
        'accepted_terms',
        'terms_accepted_at',
        'is_access',
        'access_mes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
        'date_of_joining' => 'date',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'accepted_terms' => 'boolean',
        'terms_accepted_at' => 'datetime',
        'is_access' => 'boolean',
    ];

    /**
     * Get the bank that the user belongs to.
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Get the branch that the user belongs to.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the contact division for the user.
     */
    public function contactDivision()
    {
        return $this->belongsTo(Division::class, 'c_division_id');
    }

    /**
     * Get the contact district for the user.
     */
    public function contactDistrict()
    {
        return $this->belongsTo(District::class, 'c_district_id');
    }

    /**
     * Get the permanent division for the user.
     */
    public function permanentDivision()
    {
        return $this->belongsTo(Division::class, 'p_division_id');
    }

    /**
     * Get the permanent district for the user.
     */
    public function permanentDistrict()
    {
        return $this->belongsTo(District::class, 'p_district_id');
    }

    /**
     * Check if user is super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is bank admin.
     */
    public function isBankAdmin(): bool
    {
        return $this->role === 'bank_admin';
    }

    /**
     * Check if user is branch admin.
     */
    public function isBranchAdmin(): bool
    {
        return $this->role === 'branch_admin';
    }

    /**
     * Check if user is customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function leadAccesses()
    {
        return $this->hasMany(LeadAccess::class, 'officer_id');
    }

    public function packageOrders()
    {
        return $this->hasMany(PackageOrder::class);
    }

    public function customerDocument()
    {
        return $this->belongsTo(CustomerDocument::class, 'customer_document_id');
    }

    public function customerFinancial()
    {
        return $this->belongsTo(CustomerFinancial::class, 'customer_financial_id');
    }

    public function bankOfficial()
    {
        return $this->belongsTo(BankOfficial::class, 'bank_official_id');
    }

    public function officerDocument()
    {
        return $this->belongsTo(OfficerDocument::class, 'officer_document_id');
    }

    public function customerRatingsReceived()
    {
        return $this->hasMany(CustomerRating::class, 'customer_id');
    }

    public function customerRatingsGiven()
    {
        return $this->hasMany(CustomerRating::class, 'branch_admin_id');
    }

    public function bankOfficerRatingsReceived()
    {
        return $this->hasMany(BankOfficerRating::class, 'officer_id');
    }

    public function bankOfficerRatingsGiven()
    {
        return $this->hasMany(BankOfficerRating::class, 'customer_id');
    }
}

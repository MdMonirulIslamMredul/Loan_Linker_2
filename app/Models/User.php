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
}

<?php

namespace App\Models;

use App\Models\LeadAccess;
use App\Models\ServiceCategory;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class NewLoanApplication extends Model
{
    protected $table = 'new_loan_application';

    protected $fillable = [
        'customer_id',
        'expected_amount',
        'tenure_months',
        'service_category',
        'service_type',
        'service_category_id',
        'service_type_id',
        'bank_ids',
        'additional_notes',
        'status',
        'admin_view',
        'branch_view',
    ];

    protected $casts = [
        'bank_ids' => 'array',
        'customer_id' => 'integer',
        'admin_view' => 'boolean',
        'branch_view' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function leadAccesses()
    {
        return $this->hasMany(LeadAccess::class, 'newloan_id');
    }

    public function isEditableByCustomer(): bool
    {
        if ($this->status === 'pending') {
            return true;
        }

        if ($this->status === 'active') {
            if ($this->relationLoaded('leadAccesses')) {
                $leadAccesses = $this->leadAccesses;
                return $leadAccesses->isEmpty() || $leadAccesses->contains('application_status', 'pending');
            }

            if ($this->leadAccesses()->where('application_status', 'pending')->exists()) {
                return true;
            }

            return ! $this->leadAccesses()->exists();
        }

        return false;
    }

    public function customerRatings()
    {
        return $this->hasMany(CustomerRating::class, 'new_loan_application_id');
    }

    public function bankOfficerRatings()
    {
        return $this->hasMany(BankOfficerRating::class, 'new_loan_application_id');
    }
}

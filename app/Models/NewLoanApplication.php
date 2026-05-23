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
    ];

    protected $casts = [
        'bank_ids' => 'array',
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

    public function customerRatings()
    {
        return $this->hasMany(CustomerRating::class, 'new_loan_application_id');
    }

    public function bankOfficerRatings()
    {
        return $this->hasMany(BankOfficerRating::class, 'new_loan_application_id');
    }
}

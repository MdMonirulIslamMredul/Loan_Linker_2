<?php

namespace App\Models;

use App\Models\LeadAccess;
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

    public function leadAccesses()
    {
        return $this->hasMany(LeadAccess::class, 'newloan_id');
    }
}

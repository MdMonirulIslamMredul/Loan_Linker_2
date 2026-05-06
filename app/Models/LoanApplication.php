<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    protected $fillable = [
        'customer_id',
        'loan_id',
        'full_name',
        'email',
        'phone',
        'nid_number',
        'present_address',
        'permanent_address',
        'date_of_birth',
        'gender',
        'occupation',
        'monthly_income',
        'loan_amount',
        'tenure_months',
        'employment_type',
        'company_name',
        'purpose_of_loan',
        'documents',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'documents' => 'array',
        'date_of_birth' => 'date',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}

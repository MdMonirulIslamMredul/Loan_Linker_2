<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFinancialLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_financial_id',
        'service_category_id',
        'service_type_id',
        'bank_id',
        'loan_amount',
        'tenure_months',
    ];

    protected $casts = [
        'customer_financial_id' => 'integer',
        'service_category_id' => 'integer',
        'service_type_id' => 'integer',
        'bank_id' => 'integer',
        'loan_amount' => 'decimal:2',
        'tenure_months' => 'integer',
    ];

    public function customerFinancial()
    {
        return $this->belongsTo(CustomerFinancial::class);
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_bank_id',
        'salary_by_bank',
        'salary_by_hand',
        'monthly_bank_transaction',
        'existing_loans_credit_cards',
        'has_loan',
    ];

    protected $casts = [
        'salary_bank_id' => 'integer',
        'salary_by_bank' => 'decimal:2',
        'salary_by_hand' => 'decimal:2',
        'monthly_bank_transaction' => 'decimal:2',
        'has_loan' => 'boolean',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'customer_financial_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'salary_bank_id');
    }

    public function loans()
    {
        return $this->hasMany(CustomerFinancialLoan::class);
    }
}

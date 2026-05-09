<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_by_bank',
        'salary_by_hand',
        'monthly_bank_transaction',
        'existing_loans_credit_cards',
    ];

    protected $casts = [
        'salary_by_bank' => 'decimal:2',
        'salary_by_hand' => 'decimal:2',
        'monthly_bank_transaction' => 'decimal:2',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'customer_financial_id');
    }
}

<?php

namespace App\Models;

use App\Models\NewLoanApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankOfficerRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'officer_id',
        'new_loan_application_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function newLoanApplication()
    {
        return $this->belongsTo(NewLoanApplication::class, 'new_loan_application_id');
    }
}

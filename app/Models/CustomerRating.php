<?php

namespace App\Models;

use App\Models\NewLoanApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'branch_admin_id',
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

    public function branchAdmin()
    {
        return $this->belongsTo(User::class, 'branch_admin_id');
    }

    public function newLoanApplication()
    {
        return $this->belongsTo(NewLoanApplication::class, 'new_loan_application_id');
    }
}

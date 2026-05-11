<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LoanApplication;
use App\Models\NewLoanApplication;
use App\Models\User;

class LeadAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'officer_id',
        'application_id',
        'newloan_id',
        'purchased_at',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
    ];

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function application()
    {
        return $this->belongsTo(LoanApplication::class, 'application_id');
    }

    public function newLoanApplication()
    {
        return $this->belongsTo(NewLoanApplication::class, 'newloan_id');
    }
}

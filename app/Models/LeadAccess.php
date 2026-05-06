<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'officer_id',
        'application_id',
        'purchased_at',
    ];

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function application()
    {
        return $this->belongsTo(LoanApplication::class, 'application_id');
    }
}

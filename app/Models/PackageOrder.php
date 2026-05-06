<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lead_package_id',
        'price',
        'number_of_leads',
        'status',
        'updated_by',
        'approved_at',
        'payment_method',
        'txn_number',
        'bank_name',
        'account_no',
        'phone',
        'screenshot',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leadPackage()
    {
        return $this->belongsTo(LeadPackage::class);
    }
}

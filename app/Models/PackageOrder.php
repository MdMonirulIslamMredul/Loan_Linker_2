<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\LeadPackage;

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
        'expired_at',
        'rejected_at',
        'payment_method',
        'payment_method_id',
        'txn_number',
        'bank_name',
        'account_no',
        'phone',
        'screenshot',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'expired_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leadPackage()
    {
        return $this->belongsTo(LeadPackage::class);
    }
}

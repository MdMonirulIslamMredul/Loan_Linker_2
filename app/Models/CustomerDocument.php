<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'picture',
        'nid',
        'office_id',
        'visiting_card',
        'pay_slip',
        'bank_statements',
        'trade_license',
        'tin_certificate',
        'lend_document',
        'other_document',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'customer_document_id');
    }
}

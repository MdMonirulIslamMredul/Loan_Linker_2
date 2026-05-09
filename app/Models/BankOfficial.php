<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankOfficial extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'branch_name',
        'designation',
        'department',
        'office_id_number',
        'date_of_joining',
        'official_mobile_number',
        'official_email',
        'working_area',
    ];

    protected $casts = [
        'date_of_joining' => 'date',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'bank_official_id');
    }
}

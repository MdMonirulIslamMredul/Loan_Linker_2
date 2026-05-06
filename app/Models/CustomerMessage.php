<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMessage extends Model
{
    use HasFactory;

    protected $table = 'customer_messages';

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'email',
        'message',
        'ip_address',
        'user_agent',
        'is_read',
    ];
}

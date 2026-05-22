<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermCondition extends Model
{
    protected $fillable = [
        'title',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageCarousel extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'short_description',
        'button_name',
        'button_url',
        'is_active',
        'sort_order',
    ];
}

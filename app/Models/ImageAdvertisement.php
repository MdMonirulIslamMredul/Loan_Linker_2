<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageAdvertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'link_url',
        'title',
        'is_active',
        'sort_order',
    ];
}

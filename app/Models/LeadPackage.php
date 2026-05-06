<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price',
        'number_of_leads',
        'duration',
        'description',
    ];
}

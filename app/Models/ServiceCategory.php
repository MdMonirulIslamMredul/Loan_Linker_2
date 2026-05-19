<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function serviceTypes()
    {
        return $this->hasMany(ServiceType::class, 'service_category_id');
    }

    public function newLoanApplications()
    {
        return $this->hasMany(NewLoanApplication::class, 'service_category_id');
    }
}

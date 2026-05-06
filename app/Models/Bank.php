<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'details',
        'logo',
        'banner',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the branches for the bank.
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    /**
     * Get the bank admins for the bank.
     */
    public function bankAdmins()
    {
        return $this->hasMany(User::class)->where('role', 'bank_admin');
    }

    /**
     * Get all users associated with this bank.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
